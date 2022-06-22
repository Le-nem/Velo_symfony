<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621123113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, delivery_date DATETIME NOT NULL, INDEX IDX_FE86641079F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignes (id INT AUTO_INCREMENT NOT NULL, id_facture_id INT DEFAULT NULL, quantity INT DEFAULT NULL, INDEX IDX_6FE8ED4ADAA76EDF (id_facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641079F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lignes ADD CONSTRAINT FK_6FE8ED4ADAA76EDF FOREIGN KEY (id_facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE article ADD lignes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E665E4D2AA2 FOREIGN KEY (lignes_id) REFERENCES lignes (id)');
        $this->addSql('CREATE INDEX IDX_23A0E665E4D2AA2 ON article (lignes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignes DROP FOREIGN KEY FK_6FE8ED4ADAA76EDF');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E665E4D2AA2');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE lignes');
        $this->addSql('DROP INDEX IDX_23A0E665E4D2AA2 ON article');
        $this->addSql('ALTER TABLE article DROP lignes_id');
    }
}
