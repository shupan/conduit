<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160912132242 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("insert into tmp_spec_gv(id) VALUE ('1002');");
        $this->addSql("insert into tmp_spec_gv(id) VALUE ('1003');");
        $this->addSql("insert into tmp_spec_gv(id) VALUE ('1004');");
        $this->addSql("insert into tmp_spec_gv(id) VALUE ('1005');");
        $this->addSql("insert into tmp_spec_gv(id) VALUE ('1006');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
