<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513121113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, price_unit DOUBLE PRECISION NOT NULL, INDEX IDX_F0FE25271AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item_product (cart_item_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_AE98B090E9B59A59 (cart_item_id), INDEX IDX_AE98B0904584665A (product_id), PRIMARY KEY(cart_item_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_item_product ADD CONSTRAINT FK_AE98B090E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_item_product ADD CONSTRAINT FK_AE98B0904584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE cart_item_product DROP FOREIGN KEY FK_AE98B090E9B59A59');
        $this->addSql('ALTER TABLE cart_item_product DROP FOREIGN KEY FK_AE98B0904584665A');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE cart_item_product');
    }
}
