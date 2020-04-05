<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405182702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE wishlist');
        $this->addSql('ALTER TABLE address CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE digicode digicode VARCHAR(20) DEFAULT NULL, CHANGE floor floor VARCHAR(5) DEFAULT NULL, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery CHANGE order_id order_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL, CHANGE date_payment date_payment DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD category_id INT DEFAULT NULL, CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE specifications specifications VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE wishlist (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_9CE12A319395C3F3 (customer_id), INDEX IDX_9CE12A314584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A314584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A319395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE address CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE digicode digicode VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE floor floor VARCHAR(5) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE delivery CHANGE order_id order_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL, CHANGE date_payment date_payment DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product DROP category_id, CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT \'NULL\', CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE specifications specifications VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
