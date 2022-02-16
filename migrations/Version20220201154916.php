<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201154916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crypto_investment (id INT AUTO_INCREMENT NOT NULL, gain DOUBLE PRECISION DEFAULT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crypto_market (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crypto_wallet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, actif TINYINT(1) NOT NULL, coef INT NOT NULL, symbol VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, name_id INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_723705D171179CD6 (name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D171179CD6 FOREIGN KEY (name_id) REFERENCES crypto_wallet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D171179CD6');
        $this->addSql('DROP TABLE crypto_investment');
        $this->addSql('DROP TABLE crypto_market');
        $this->addSql('DROP TABLE crypto_wallet');
        $this->addSql('DROP TABLE transaction');
    }
}
