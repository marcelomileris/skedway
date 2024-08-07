drop database if exists `db_skedway`;
create database `db_skedway`;
use `db_skedway`;

create table `events` (
    `id`              	integer not null primary key auto_increment,
    `title`            	varchar(500) not null,
    `description`       varchar(200) not null,
    `start_datetime`    timestamp not null,
    `end_datetime`      timestamp not null,
    `created_at`        timestamp not null default current_timestamp, 
    `updated_at`        timestamp null on update current_timestamp,
    `deleted_at`        timestamp null
)engine=MyISAM;
