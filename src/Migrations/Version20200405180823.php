<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405180823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE digicode digicode VARCHAR(20) DEFAULT NULL, CHANGE floor floor VARCHAR(5) DEFAULT NULL, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery CHANGE order_id order_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939848E1E977');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B171EB6C');
        $this->addSql('DROP INDEX IDX_F529939848E1E977 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398B171EB6C ON `order`');
        $this->addSql('ALTER TABLE `order` ADD customer_id INT DEFAULT NULL, ADD address_id INT DEFAULT NULL, DROP customer_id_id, DROP address_id_id, CHANGE date_payment date_payment DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_F52993989395C3F3 ON `order` (customer_id)');
        $this->addSql('CREATE INDEX IDX_F5299398F5B7AF75 ON `order` (address_id)');
        $this->addSql('ALTER TABLE product CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE specifications specifications VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE digicode digicode VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE floor floor VARCHAR(5) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE delivery CHANGE order_id order_id INT DEFAULT NULL, CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F5B7AF75');
        $this->addSql('DROP INDEX IDX_F52993989395C3F3 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398F5B7AF75 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD customer_id_id INT DEFAULT NULL, ADD address_id_id INT DEFAULT NULL, DROP customer_id, DROP address_id, CHANGE date_payment date_payment DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939848E1E977 FOREIGN KEY (address_id_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_F529939848E1E977 ON `order` (address_id_id)');
        $this->addSql('CREATE INDEX IDX_F5299398B171EB6C ON `order` (customer_id_id)');
        $this->addSql('ALTER TABLE product CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT \'NULL\', CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE specifications specifications VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
