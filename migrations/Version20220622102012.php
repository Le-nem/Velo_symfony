<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622102012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignes DROP FOREIGN KEY FK_6FE8ED4ADAA76EDF');
        $this->addSql('ALTER TABLE lignes DROP FOREIGN KEY FK_6FE8ED4AD71E064B');
        $this->addSql('DROP INDEX IDX_6FE8ED4ADAA76EDF ON lignes');
        $this->addSql('DROP INDEX IDX_6FE8ED4AD71E064B ON lignes');
        $this->addSql('ALTER TABLE lignes ADD facture_id INT NOT NULL, ADD article_id INT NOT NULL, DROP id_facture_id, DROP id_article_id');
        $this->addSql('ALTER TABLE lignes ADD CONSTRAINT FK_6FE8ED4A7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE lignes ADD CONSTRAINT FK_6FE8ED4A7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_6FE8ED4A7F2DEE08 ON lignes (facture_id)');
        $this->addSql('CREATE INDEX IDX_6FE8ED4A7294869C ON lignes (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignes DROP FOREIGN KEY FK_6FE8ED4A7F2DEE08');
        $this->addSql('ALTER TABLE lignes DROP FOREIGN KEY FK_6FE8ED4A7294869C');
        $this->addSql('DROP INDEX IDX_6FE8ED4A7F2DEE08 ON lignes');
        $this->addSql('DROP INDEX IDX_6FE8ED4A7294869C ON lignes');
        $this->addSql('ALTER TABLE lignes ADD id_facture_id INT DEFAULT NULL, ADD id_article_id INT DEFAULT NULL, DROP facture_id, DROP article_id');
        $this->addSql('ALTER TABLE lignes ADD CONSTRAINT FK_6FE8ED4ADAA76EDF FOREIGN KEY (id_facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE lignes ADD CONSTRAINT FK_6FE8ED4AD71E064B FOREIGN KEY (id_article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_6FE8ED4ADAA76EDF ON lignes (id_facture_id)');
        $this->addSql('CREATE INDEX IDX_6FE8ED4AD71E064B ON lignes (id_article_id)');
    }
}
