<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513184951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, orders_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3781EC10CFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, sales_order_id_id INT DEFAULT NULL, payment_method VARCHAR(255) NOT NULL, payment_status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6D28840DB8D1FB6E (sales_order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order_addresses (id INT AUTO_INCREMENT NOT NULL, sales_order_id_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_A5C3E2BAB8D1FB6E (sales_order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order_line (id INT AUTO_INCREMENT NOT NULL, unit_price INT NOT NULL, quantity INT NOT NULL, value_added_tax INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, rate INT NOT NULL, wording VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES sales_order (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB8D1FB6E FOREIGN KEY (sales_order_id_id) REFERENCES sales_order (id)');
        $this->addSql('ALTER TABLE sales_order_addresses ADD CONSTRAINT FK_A5C3E2BAB8D1FB6E FOREIGN KEY (sales_order_id_id) REFERENCES sales_order (id)');
        $this->addSql('ALTER TABLE address ADD sales_order_addresses_id INT DEFAULT NULL, ADD number VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81C0ADBC37 FOREIGN KEY (sales_order_addresses_id) REFERENCES sales_order_addresses (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F81C0ADBC37 ON address (sales_order_addresses_id)');
        $this->addSql('ALTER TABLE product ADD categories_id INT DEFAULT NULL, ADD sales_order_line_id INT DEFAULT NULL, ADD taxes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7E27AABA FOREIGN KEY (sales_order_line_id) REFERENCES sales_order_line (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD36D06393 FOREIGN KEY (taxes_id) REFERENCES tax (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA21214B7 ON product (categories_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7E27AABA ON product (sales_order_line_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD36D06393 ON product (taxes_id)');
        $this->addSql('ALTER TABLE sales_order ADD sales_order_line_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sales_order ADD CONSTRAINT FK_36D222E7E27AABA FOREIGN KEY (sales_order_line_id) REFERENCES sales_order_line (id)');
        $this->addSql('CREATE INDEX IDX_36D222E7E27AABA ON sales_order (sales_order_line_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA21214B7');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81C0ADBC37');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7E27AABA');
        $this->addSql('ALTER TABLE sales_order DROP FOREIGN KEY FK_36D222E7E27AABA');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD36D06393');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10CFFE9AD6');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DB8D1FB6E');
        $this->addSql('ALTER TABLE sales_order_addresses DROP FOREIGN KEY FK_A5C3E2BAB8D1FB6E');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE sales_order_addresses');
        $this->addSql('DROP TABLE sales_order_line');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP INDEX IDX_D4E6F81C0ADBC37 ON address');
        $this->addSql('ALTER TABLE address DROP sales_order_addresses_id, DROP number, DROP city');
        $this->addSql('DROP INDEX IDX_D34A04ADA21214B7 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD7E27AABA ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD36D06393 ON product');
        $this->addSql('ALTER TABLE product DROP categories_id, DROP sales_order_line_id, DROP taxes_id');
        $this->addSql('DROP INDEX IDX_36D222E7E27AABA ON sales_order');
        $this->addSql('ALTER TABLE sales_order DROP sales_order_line_id');
    }
}
