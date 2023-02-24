<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224105931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1E27938F7');
        $this->addSql('DROP INDEX IDX_64C19C1E27938F7 ON category');
        $this->addSql('ALTER TABLE category DROP fk_category_id_id, DROP description, DROP prix, CHANGE photo nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE27938F7');
        $this->addSql('DROP INDEX IDX_D34A04ADE27938F7 ON product');
        $this->addSql('ALTER TABLE product ADD name VARCHAR(255) NOT NULL, ADD picture VARCHAR(255) NOT NULL, DROP nom, DROP photo, CHANGE description description VARCHAR(255) NOT NULL, CHANGE fk_category_id_id fk_category_id INT DEFAULT NULL, CHANGE prix price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7BB031D6 FOREIGN KEY (fk_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7BB031D6 ON product (fk_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD fk_category_id_id INT DEFAULT NULL, ADD description LONGTEXT NOT NULL, ADD prix DOUBLE PRECISION NOT NULL, CHANGE nom photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1E27938F7 FOREIGN KEY (fk_category_id_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1E27938F7 ON category (fk_category_id_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7BB031D6');
        $this->addSql('DROP INDEX IDX_D34A04AD7BB031D6 ON product');
        $this->addSql('ALTER TABLE product ADD nom VARCHAR(255) NOT NULL, ADD photo VARCHAR(255) NOT NULL, DROP name, DROP picture, CHANGE description description LONGTEXT NOT NULL, CHANGE fk_category_id fk_category_id_id INT DEFAULT NULL, CHANGE price prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE27938F7 FOREIGN KEY (fk_category_id_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADE27938F7 ON product (fk_category_id_id)');
    }
}
