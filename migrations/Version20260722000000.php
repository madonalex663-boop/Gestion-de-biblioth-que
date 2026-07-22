<?php
declare(strict_types=1);
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20260722000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables auteur, categorie, livre et emprunt';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, biographie LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, categorie_id INT NOT NULL, titre VARCHAR(255) NOT NULL, isbn VARCHAR(20) DEFAULT NULL, date_edition DATE DEFAULT NULL, disponible TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_LIVRE_ISBN (isbn), INDEX IDX_LIVRE_AUTEUR (auteur_id), INDEX IDX_LIVRE_CATEGORIE (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, emprunteur VARCHAR(150) NOT NULL, date_emprunt DATE NOT NULL, date_retour_prevue DATE NOT NULL, date_retour_effective DATE DEFAULT NULL, rendu TINYINT(1) NOT NULL, INDEX IDX_EMPRUNT_LIVRE (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_LIVRE_AUTEUR FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_LIVRE_CATEGORIE FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_EMPRUNT_LIVRE FOREIGN KEY (livre_id) REFERENCES livre (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_LIVRE_AUTEUR');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_LIVRE_CATEGORIE');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_EMPRUNT_LIVRE');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE emprunt');
    }
}
