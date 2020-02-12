Feature: Repository comparison
	In order to compare two repositories
	As a developer
	I want to provide an identifier to the repository

	Rules:
	- identifier can be a link or a slug

	Scenario: Putting two links into comparison.
        Given there is a repository "https://github.com/Behat/Behat"
        And there is another repository "https://github.com/sebastianbergmann/phpunit"
        When I compare them
        Then the result should be correct

    Scenario: Putting two slugs into comparison.
        Given there is a repository "Behat/Behat"
        And there is another repository "sebastianbergmann/phpunit"
        When I compare them
        Then the result should be correct

    Scenario: Putting link and slug into comparison.
        Given there is a repository "https://github.com/Behat/Behat"
        And there is another repository "sebastianbergmann/phpunit"
        When I compare them
        Then the result should be correct