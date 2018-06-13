#!/bin/bash

########################################################################
################################ README ################################
########################################################################
#
# This script is here to allow the use of "git push prod v1.2.3" commands or similar.
#
# Push a tag to a bare repository having this file as pre-receive hook,
#  and you'll be able to deploy directly from command line in your local environment,
#  as long as you create a git remote pointing to this bare repo via ssh.
#
# For more info, full readme can be found here: https://gist.github.com/Pierstoval/27e8f309034fa0ababa1
#
# Enjoy! :)



# Working Tree
# This var corresponds to the project you are working on.
# This is where the fetch & checkout will occur for deployment.
workingtree="/home/esteren/www/portal.esteren.org/www"



# Success Script for a git TAG reference
# Example of script executed after a successful deploy
# Change it accordingly if you want to use proper commands for your projects
# This script is executed after a "cd" to the $workingtree directory.
# Here is an example for a Symfony project
read -d '' success_tag_script << SCRIPT
    export SYMFONY_ENV=prod && \
    export SYMFONY_DEBUG=0 && \
    composer install --optimize-autoloader --no-dev --apcu-autoloader && \
    php bin/console cache:clear && \
    php bin/console doctrine:migrations:migrate --no-interaction
SCRIPT



# Success Script for a git NON-TAG reference
# This script is executed if you push something else than a tag.
# Actually, if you don't push a tag, we cannot know exactly the branch you're pushing.
# (Note: I may not have discovered it yet, actually, feel free to enlighten me if you know!)
# So it's your job to specify another script to be executed!
read -d '' success_nontag_script  << SCRIPT
    echo "This is not a tag, so I will not do anything.'
    exit 1
SCRIPT







####
#### Script start
####

# You should not modify anything starting here.
# But still, if you want to read the comments... ;)

echo "[INFO] Receiving the current push as `whoami`."

gitcmd="git --git-dir=${workingtree}/.git --work-tree=${workingtree}"

# References are sent in stdin for the pre-receive script.
# We then get all refs manually and we can do something on each ref.
echo "[INFO] Reading stdin..."
while read line
do
    echo "[INFO] Line to read: $line"

    # Only if line is not empty.
    if [[ -n "${line// }" ]]; then

        # Split the line into array.
        IFS=' ' read -r -a array <<< "$line"

        # This is the standard Git behavior for pre-receive:
        parentsha=${array[0]}
        currentsha=${array[1]}
        ref=${array[2]}

        echo "[INFO] "
        echo "[INFO] Current line:"
        echo "[INFO] > Parent sha: $parentsha"
        echo "[INFO] > Current sha: $currentsha"
        echo "[INFO] > Ref: $ref"

        if [[ "$ref" =~ ^refs\/tags\/ ]]; then

            # Here, we have a tag, so we may create a special branch and deploy!

            # Regex replace the tag to get only its name.
            tag=${ref/refs\/tags\//}

            # This var will be used to check the return code of each command.
            cmdcode=0

            echo "[INFO] "
            echo "[INFO] Received a tag: $tag."

            # Execute fetch and check that the command succeeds.
            echo "[INFO] "
            echo "[INFO] Fetching repository..."

            $gitcmd fetch --all --prune --tags
            cmdcode=$?

            if [ $cmdcode -ne 0 ]; then
                echo "[INFO] Could not fetch repository."
                exit 100
            else
                # If we could fetch, we create a branch based on $tag.
                # And we check that it succeeds.
                echo "[INFO] "
                echo "[INFO] Creating a new branch based on the tag."

                currentbranch=`$gitcmd name-rev --name-only HEAD`
                $gitcmd checkout -b "release_${tag}" "tags/${tag}"
                cmdcode=$?

                if [ $cmdcode -ne 0 ]; then
                    echo "[INFO] Could not create branch."
                    exit 110
                else
                    echo "[SUCCESS] Successfully checked out the \"release_${tag}\" branch!"
                    echo "[INFO] If you need to rollback, just checkout the previous branch with this command:"
                    echo "[INFO] \$ $gitcmd checkout $currentbranch"
                fi
            fi # end if fetch failed/succeeded

            if [ $cmdcode -ne 0 ]; then
                # We add a message here to stop the process with a proper error message.
                # Every other message sent by Git is sent to stderr so we can check on it.
                echo "[ERROR] Could not deploy to $workingtree."
                exit 120
            else

                # SUCCESS!
                # Here, no command failed so we can deploy and do what we want!
                echo "[SUCCESS] Deployed! Now, executing scripts..."

                # Move to the directory to execute scripts
                cd $workingtree

                # And execute the script!
                eval $success_tag_script

                cmdcode=$?

                if [ $cmdcode -ne 0 ]; then
                    echo "[INFO] Post-deploy script failed and returned exit code ${cmdcode}."
                    exit 130
                else
                    echo "[SUCCESS] Deployed!"
                fi

            fi # end if commands failed/succeeded

            # End of "tag" deployment

        else

            # Here it means the pushed ref is not a tag, so it's certainly a branch.
            # You can do something else if you want, like checkout the branch and deploy it...
            # By default, we do nothing, it's your role to check everything.
            # If you want a hint, many users may simply do a "git pull origin master" in
            #  their distant repository...
            echo "[INFO] Not a tag, executing the plain configured script."

            # Move to the directory to execute scripts
            cd $workingtree

            # And execute the script!
            eval $success_nontag_script

            cmdcode=$?

            if [ $cmdcode -ne 0 ]; then
                echo "[INFO] Post-deploy script failed and returned exit code ${cmdcode}."
                exit 140
            else
                echo "[SUCCESS] Deployed!"
            fi

        fi

    fi # endif line is not empty
done < "${ST:-/dev/stdin}"

echo "[INFO] End of pre-receive script."

# Copyright (c) 2016 Alex Rock Ancelet <pierstoval@gmail.com>
# MIT license - https://opensource.org/licenses/MIT
# Source: https://gist.github.com/Pierstoval/27e8f309034fa0ababa1
