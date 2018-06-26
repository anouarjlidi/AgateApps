<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * DEV/PROD DATABASE
 *
 * Migration to remove unused tables
 */
final class Version20180625133319 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->skipIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mails_sent DROP FOREIGN KEY FK_A34C3D90C8776F01');
        $this->addSql('ALTER TABLE orbitale_cms_categories DROP FOREIGN KEY FK_A8EF7232727ACA70');
        $this->addSql('ALTER TABLE orbitale_cms_pages DROP FOREIGN KEY FK_C0E694ED12469DE2');
        $this->addSql('ALTER TABLE orbitale_cms_pages DROP FOREIGN KEY FK_C0E694ED727ACA70');
        $this->addSql('DROP TABLE mails');
        $this->addSql('DROP TABLE mails_sent');
        $this->addSql('DROP TABLE orbitale_cms_categories');
        $this->addSql('DROP TABLE orbitale_cms_pages');
        $this->addSql('DROP TABLE regions');
    }

    public function down(Schema $schema) : void
    {
    }
}
