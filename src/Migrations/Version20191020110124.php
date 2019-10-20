<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020110124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE poker_hands ADD poker_hands_file_id INT NOT NULL');
        $this->addSql('ALTER TABLE poker_hands ADD CONSTRAINT FK_D557B2819F668BBA FOREIGN KEY (poker_hands_file_id) REFERENCES poker_hands_file (id)');
        $this->addSql('CREATE INDEX IDX_D557B2819F668BBA ON poker_hands (poker_hands_file_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE poker_hands DROP FOREIGN KEY FK_D557B2819F668BBA');
        $this->addSql('DROP INDEX IDX_D557B2819F668BBA ON poker_hands');
        $this->addSql('ALTER TABLE poker_hands DROP poker_hands_file_id');
    }
}
