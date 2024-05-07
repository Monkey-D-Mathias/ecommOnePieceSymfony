<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507135131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_cart DROP FOREIGN KEY FK_864BAA161AD5CDBF');
        $this->addSql('ALTER TABLE product_cart DROP FOREIGN KEY FK_864BAA164584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA21214B7');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB2A824D8');
        $this->addSql('ALTER TABLE paymant DROP FOREIGN KEY FK_6A212CD1C023F51C');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE14584665A');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1C023F51C');
        $this->addSql('ALTER TABLE order_address DROP FOREIGN KEY FK_FB34C6CAC023F51C');
        $this->addSql('ALTER TABLE order_address DROP FOREIGN KEY FK_FB34C6CAF5B7AF75');
        $this->addSql('ALTER TABLE delivry DROP FOREIGN KEY FK_C4ECCDAAC023F51C');
        $this->addSql('DROP TABLE product_cart');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE paymant');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP TABLE order_address');
        $this->addSql('DROP TABLE delivry');
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE address ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP city, DROP date_create, DROP date_delete, CHANGE additional additionnal VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD saved_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP date_save, DROP date_create, DROP date_delete');
        $this->addSql('ALTER TABLE sales_order DROP FOREIGN KEY FK_36D222EBCB5C6F5');
        $this->addSql('DROP INDEX IDX_36D222EBCB5C6F5 ON sales_order');
        $this->addSql('ALTER TABLE sales_order ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP date_create, DROP date_delete, CHANGE carts_id cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE sales_order ADD CONSTRAINT FK_36D222E1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_36D222E1AD5CDBF ON sales_order (cart_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D6495126AC48 ON user');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD is_verified TINYINT(1) NOT NULL, DROP date_create, DROP date_delete, CHANGE mail email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_cart (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, product_id INT DEFAULT NULL, quantity INT NOT NULL, date_create DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_864BAA161AD5CDBF (cart_id), UNIQUE INDEX UNIQ_864BAA164584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, tax_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, price_wt INT NOT NULL, stock INT NOT NULL, date_create DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_D34A04ADB2A824D8 (tax_id), UNIQUE INDEX UNIQ_D34A04ADA21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE paymant (id INT AUTO_INCREMENT NOT NULL, sales_order_id INT DEFAULT NULL, average VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, date_create DATETIME NOT NULL, INDEX IDX_6A212CD1C023F51C (sales_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, sales_order_id INT DEFAULT NULL, product_id INT DEFAULT NULL, price_unit INT NOT NULL, quantity INT NOT NULL, tva INT NOT NULL, date_create DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_9CE58EE1C023F51C (sales_order_id), UNIQUE INDEX UNIQ_9CE58EE14584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, rate INT NOT NULL, wording VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, date_create DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_address (address_id INT NOT NULL, sales_order_id INT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, main TINYINT(1) DEFAULT NULL, INDEX IDX_FB34C6CAC023F51C (sales_order_id), INDEX IDX_FB34C6CAF5B7AF75 (address_id), PRIMARY KEY(address_id, sales_order_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE delivry (id INT AUTO_INCREMENT NOT NULL, sales_order_id INT DEFAULT NULL, status VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, date_create DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_C4ECCDAAC023F51C (sales_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, date_create DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_cart ADD CONSTRAINT FK_864BAA161AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product_cart ADD CONSTRAINT FK_864BAA164584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA21214B7 FOREIGN KEY (categories_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE paymant ADD CONSTRAINT FK_6A212CD1C023F51C FOREIGN KEY (sales_order_id) REFERENCES sales_order (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE14584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1C023F51C FOREIGN KEY (sales_order_id) REFERENCES sales_order (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_address ADD CONSTRAINT FK_FB34C6CAC023F51C FOREIGN KEY (sales_order_id) REFERENCES sales_order (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_address ADD CONSTRAINT FK_FB34C6CAF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE delivry ADD CONSTRAINT FK_C4ECCDAAC023F51C FOREIGN KEY (sales_order_id) REFERENCES sales_order (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE sales_order DROP FOREIGN KEY FK_36D222E1AD5CDBF');
        $this->addSql('DROP INDEX IDX_36D222E1AD5CDBF ON sales_order');
        $this->addSql('ALTER TABLE sales_order ADD date_create DATETIME NOT NULL, ADD date_delete DATETIME DEFAULT NULL, DROP created_at, CHANGE cart_id carts_id INT NOT NULL');
        $this->addSql('ALTER TABLE sales_order ADD CONSTRAINT FK_36D222EBCB5C6F5 FOREIGN KEY (carts_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_36D222EBCB5C6F5 ON sales_order (carts_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON `user`');
        $this->addSql('ALTER TABLE `user` ADD date_create DATETIME NOT NULL, ADD date_delete DATETIME DEFAULT NULL, DROP created_at, DROP deleted_at, DROP is_verified, CHANGE email mail VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495126AC48 ON `user` (mail)');
        $this->addSql('ALTER TABLE address ADD city VARCHAR(255) NOT NULL, ADD date_create DATETIME NOT NULL, ADD date_delete DATETIME DEFAULT NULL, DROP created_at, DROP deleted_at, CHANGE additionnal additional VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD date_save DATETIME DEFAULT NULL, ADD date_create DATETIME NOT NULL, ADD date_delete DATETIME DEFAULT NULL, DROP created_at, DROP saved_at');
    }
}
