
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# Corahn Rin / Character manager

## Bundles

It's composed of two bundles:

* **PierstovalCharacterManagerBundle** is a "standard" implementation of a character manager. It does not have
logic, but proposes a `Character` class, interfaces and abstract classes to be overriden in the application.<br>
:information_source: **Note:** Try to be as much "standard" as you can: this generator **must** be usable for another game.
* **CorahnRinBundle** implements the character manager class, stores all entities specific to Shadows of Esteren
game. Everything non-standard should be here.

## Configuration

The `pierstoval_character_manager.character` extension parameter **must** be provided. It allows the "standard" bundle to know which class is used in the application.

The class **must** extend the Model provided in the bundle.

## Routing

The character manager and generator relies under the `%esteren_domains.corahnrin%` domain.

Some routes are imported from the `PierstovalCharacterManagerBundle`, some in `CorahnRinBundle`.

## Steps

When you create a character, there are tons of steps to create it.

Each step must be defined in a class that have to implement the `StepActionInterface` interface provided by the bundle.
**Note:** An abstract `StepAction` class can be used too, it already implements the interface and defines basic behaviors.
In the `CorahnRinBundle`, another abstract class extends the base one, to implement other common behaviors. Ideally, it could be good to get rid of so many abstract classes and have only one in `PierstovalCharacterManagerBundle`...

Step actions can be defined either as simple classes or as services.

### Steps workflow in the controller

1. The controller route is called at the route `/{_locale}/generate/{requestStep}`.
2. The step is validated to be sure that:
  * It exists
  * The character has access to it (meaning all previous steps are defined in the character stored in session).
3. The action is resolved (whether it's a service or a simple class)
4. Some mandatory parameters are set in it via simple setters (request, current step, steps list, etc.).
5. `StepAction::execute()` is executed and must return a `Response`.
  * Logic is managed in the action.
  * Some methods are used to retrieve data from the character and/or update the character itself.
  * A `nextStep()` method allows redirection to next step.
  * A `renderCurrentStep($params)` method allows automatic step twig template resolution with this pattern:
    `@CorahnRin/Steps/{stepName}.html.twig`. It should extend the `@CorahnRin/Steps/step_base.html.twig` template.
6. Tons of javascript helpers are developed with a "standard" policy to be able to reproduce similar behavior through
  similar steps (choosing with hovered-divs or buttons instead of checkboxes, etc.).<br>
  Check the [main_steps.js](src/CorahnRin/CorahnRinBundle/Resources/public/generator/js/main_steps.js) file for more info.
