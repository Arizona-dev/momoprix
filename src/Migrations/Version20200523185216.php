<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523185216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE wishlist (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, product_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_9CE12A319395C3F3 (customer_id), UNIQUE INDEX UNIQ_9CE12A314584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A319395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A314584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product CHANGE category_id category_id INT DEFAULT NULL, CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE specifications specifications VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE address CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE digicode digicode VARCHAR(20) DEFAULT NULL, CHANGE floor floor VARCHAR(5) DEFAULT NULL, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery CHANGE order_id order_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9395C3F3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEF5B7AF75');
        $this->addSql('ALTER TABLE orders CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL, CHANGE date_payment date_payment DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE product_has_order DROP FOREIGN KEY FK_600035AB4584665A');
        $this->addSql('ALTER TABLE product_has_order DROP FOREIGN KEY FK_600035AB8D9F6D38');
        $this->addSql('ALTER TABLE product_has_order CHANGE order_id order_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_has_order ADD CONSTRAINT FK_600035AB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_has_order ADD CONSTRAINT FK_600035AB8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE wishlist');
        $this->addSql('ALTER TABLE address CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE digicode digicode VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE floor floor VARCHAR(5) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE delivery CHANGE order_id order_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9395C3F3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEF5B7AF75');
        $this->addSql('ALTER TABLE orders CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL, CHANGE date_payment date_payment DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product CHANGE category_id category_id INT DEFAULT NULL, CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT \'NULL\', CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE specifications specifications VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product_has_order DROP FOREIGN KEY FK_600035AB8D9F6D38');
        $this->addSql('ALTER TABLE product_has_order DROP FOREIGN KEY FK_600035AB4584665A');
        $this->addSql('ALTER TABLE product_has_order CHANGE order_id order_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_has_order ADD CONSTRAINT FK_600035AB8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_has_order ADD CONSTRAINT FK_600035AB4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE SET NULL');
    }
}
