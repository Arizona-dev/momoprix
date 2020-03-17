<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307192129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, customer_idcustomer_id INT NOT NULL, type VARCHAR(15) NOT NULL, address VARCHAR(100) NOT NULL, cp VARCHAR(10) NOT NULL, city VARCHAR(70) NOT NULL, indoors INT NOT NULL, digicode VARCHAR(20) DEFAULT NULL, floor VARCHAR(5) DEFAULT NULL, elevator INT DEFAULT NULL, INDEX IDX_D4E6F813131C35F (customer_idcustomer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_category (category_source INT NOT NULL, category_target INT NOT NULL, INDEX IDX_B1369DBA5062B508 (category_source), INDEX IDX_B1369DBA4987E587 (category_target), PRIMARY KEY(category_source, category_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(60) NOT NULL, firstname VARCHAR(60) NOT NULL, email VARCHAR(70) NOT NULL, password VARCHAR(80) NOT NULL, date_of_birth DATE NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, address_idaddress_id INT NOT NULL, order_idorder_id INT NOT NULL, status VARCHAR(20) NOT NULL, schedule VARCHAR(15) NOT NULL, delivery DATETIME NOT NULL, date_delivery DATE NOT NULL, INDEX IDX_3781EC1034BF6654 (address_idaddress_id), UNIQUE INDEX UNIQ_3781EC109490D860 (order_idorder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_idcustomer_id INT NOT NULL, address_idaddress_id INT NOT NULL, label VARCHAR(45) NOT NULL, status VARCHAR(20) NOT NULL, date_order DATE NOT NULL, price_ht NUMERIC(6, 2) NOT NULL, price_ttc NUMERIC(6, 2) NOT NULL, date_payment DATE DEFAULT NULL, INDEX IDX_F52993983131C35F (customer_idcustomer_id), INDEX IDX_F529939834BF6654 (address_idaddress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, bar_code VARCHAR(60) NOT NULL, price NUMERIC(5, 2) NOT NULL, date_of_entry DATETIME NOT NULL, stock INT NOT NULL, description VARCHAR(255) DEFAULT NULL, category_idcategory INT NOT NULL, image_url VARCHAR(255) NOT NULL, qte SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_order (product_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_5475E8C44584665A (product_id), INDEX IDX_5475E8C48D9F6D38 (order_id), PRIMARY KEY(product_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_customer (product_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_4A89E49E4584665A (product_id), INDEX IDX_4A89E49E9395C3F3 (customer_id), PRIMARY KEY(product_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F813131C35F FOREIGN KEY (customer_idcustomer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE category_category ADD CONSTRAINT FK_B1369DBA5062B508 FOREIGN KEY (category_source) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_category ADD CONSTRAINT FK_B1369DBA4987E587 FOREIGN KEY (category_target) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC1034BF6654 FOREIGN KEY (address_idaddress_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC109490D860 FOREIGN KEY (order_idorder_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993983131C35F FOREIGN KEY (customer_idcustomer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939834BF6654 FOREIGN KEY (address_idaddress_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C44584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C48D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_customer ADD CONSTRAINT FK_4A89E49E4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_customer ADD CONSTRAINT FK_4A89E49E9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC1034BF6654');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939834BF6654');
        $this->addSql('ALTER TABLE category_category DROP FOREIGN KEY FK_B1369DBA5062B508');
        $this->addSql('ALTER TABLE category_category DROP FOREIGN KEY FK_B1369DBA4987E587');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F813131C35F');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993983131C35F');
        $this->addSql('ALTER TABLE product_customer DROP FOREIGN KEY FK_4A89E49E9395C3F3');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC109490D860');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C48D9F6D38');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C44584665A');
        $this->addSql('ALTER TABLE product_customer DROP FOREIGN KEY FK_4A89E49E4584665A');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_category');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_order');
        $this->addSql('DROP TABLE product_customer');
    }
}
