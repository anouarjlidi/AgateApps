#!/bin/bash

# Just an example of how I manage post-deploy scripts

NEW_VERSION=$1
CHANGELOG_FILE=$2

if [ -z $NEW_VERSION ]
then
    echo "Version must be specified"
    exit 1
fi

if [ -z $CHANGELOG_FILE ]
then
    echo "Changelog file must be specified"
    exit 1
fi

# Escape changelog
cat ${CHANGELOG_FILE} | php -R "echo addslashes(fread(STDIN, 9999999));" > _tmpfile
CHANGELOG_FILE=_tmpfile

CHANGELOG=$(cat ${CHANGELOG_FILE})

read -r -d '' SQL << EOF
insert into news set
    project_id = (select id from projects where identifier = "projet-test"),
    title = "Mise à jour des portails: ${NEW_VERSION}",
    summary = "",
    description = "${CHANGELOG}",
    created_on = CURRENT_TIMESTAMP()
;
EOF

echo "${SQL}" > _tmp_news_query.sql

mysql -uredmine_user -predmine_password redmine_database < _tmp_news_query.sql

cat _tmp_news_query.sql

rm _tmp_news_query.sql
rm ${CHANGELOG_FILE}
