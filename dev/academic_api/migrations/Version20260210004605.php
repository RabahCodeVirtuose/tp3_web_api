<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260210004605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nombre_de_credits INTEGER NOT NULL, syllabus CLOB NOT NULL, semestre INTEGER NOT NULL, nb_cm INTEGER NOT NULL, nb_td INTEGER NOT NULL, nb_tp INTEGER NOT NULL, is_optionnel BOOLEAN NOT NULL, enseignant_id INTEGER DEFAULT NULL, CONSTRAINT FK_FDCA8C9CE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CE455FCC0 ON cours (enseignant_id)');
        $this->addSql('CREATE TABLE enseignant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE enseignant_cours (enseignant_id INTEGER NOT NULL, cours_id INTEGER NOT NULL, PRIMARY KEY (enseignant_id, cours_id), CONSTRAINT FK_D6684A95E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6684A957ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D6684A95E455FCC0 ON enseignant_cours (enseignant_id)');
        $this->addSql('CREATE INDEX IDX_D6684A957ECF78B0 ON enseignant_cours (cours_id)');
        $this->addSql('CREATE TABLE programme (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, sous_titre VARCHAR(255) DEFAULT NULL, description CLOB NOT NULL, nombre_de_semestres INTEGER NOT NULL, nombre_de_credits INTEGER NOT NULL, programme_id INTEGER DEFAULT NULL, enseignant_id INTEGER DEFAULT NULL, CONSTRAINT FK_3DDCB9FF62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3DDCB9FFE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FF62BB7AEE ON programme (programme_id)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FFE455FCC0 ON programme (enseignant_id)');
        $this->addSql('CREATE TABLE programme_cours (programme_id INTEGER NOT NULL, cours_id INTEGER NOT NULL, PRIMARY KEY (programme_id, cours_id), CONSTRAINT FK_CED0D14B62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CED0D14B7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CED0D14B62BB7AEE ON programme_cours (programme_id)');
        $this->addSql('CREATE INDEX IDX_CED0D14B7ECF78B0 ON programme_cours (cours_id)');
        $this->addSql('CREATE TABLE reference (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteurs CLOB NOT NULL, titre VARCHAR(255) NOT NULL, editeur_optionnel VARCHAR(255) DEFAULT NULL, type_id VARCHAR(255) NOT NULL, identifiant VARCHAR(255) NOT NULL, date_de_publication INTEGER NOT NULL, cours_id INTEGER DEFAULT NULL, CONSTRAINT FK_AEA349137ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AEA349137ECF78B0 ON reference (cours_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE enseignant_cours');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE programme_cours');
        $this->addSql('DROP TABLE reference');
    }
}
