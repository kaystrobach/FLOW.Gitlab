<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20150528081126 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_group ADD identifieronremotesystem VARCHAR(255) NOT NULL");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project ADD identifieronremotesystem VARCHAR(255) NOT NULL");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_issue ADD identifieronremotesystem VARCHAR(255) NOT NULL");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_issue_comment ADD identifieronremotesystem VARCHAR(255) NOT NULL");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_milestone ADD identifieronremotesystem VARCHAR(255) NOT NULL");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_tag ADD identifieronremotesystem VARCHAR(255) NOT NULL");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_group DROP identifieronremotesystem");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project DROP identifieronremotesystem");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_issue DROP identifieronremotesystem");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_issue_comment DROP identifieronremotesystem");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_milestone DROP identifieronremotesystem");
		$this->addSql("ALTER TABLE kaystrobach_gitlab_domain_model_project_tag DROP identifieronremotesystem");
	}
}