<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621123939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E665E4D2AA2');
        $this->addSql('DROP INDEX IDX_23A0E665E4D2AA2 ON article');
        $this->addSql('ALTER TABLE article DROP lignes_id');
        $this->addSql('ALTER TABLE lignes ADD id_article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lignes ADD CONSTRAINT FK_6FE8ED4AD71E064B FOREIGN KEY (id_article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_6FE8ED4AD71E064B ON lignes (id_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD lignes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E665E4D2AA2 FOREIGN KEY (lignes_id) REFERENCES lignes (id)');
        $this->addSql('CREATE INDEX IDX_23A0E665E4D2AA2 ON article (lignes_id)');
        $this->addSql('ALTER TABLE lignes DROP FOREIGN KEY FK_6FE8ED4AD71E064B');
        $this->addSql('DROP INDEX IDX_6FE8ED4AD71E064B ON lignes');
        $this->addSql('ALTER TABLE lignes DROP id_article_id');
    }
}
