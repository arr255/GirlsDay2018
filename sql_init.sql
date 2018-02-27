-- sql_init.sql
drop database if exists GirlsDay;
CREATE database GirlsDay;
use GirlsDay;
drop table if exists wish;
create table wish(
    `id` smallint not null,
    `name` varchar(4) not null,
    `password` varchar(10) not null,
    `phonenumber` varchar(11) not null,
    `qq` varchar(10) not null,
    `class` varchar(20) not null,
    `wishes` varchar(50) not null,
    `status` boolean DEFAULT 0,
    `createTime` int not null,
    primary key(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists claim;
create table claim(
    `id` smallint not null,
    `name` varchar(4) not null,
    `phonenumber` varchar(11) not null,
    `qq` varchar(10) not null,
    `class` varchar(20) not null,
    `createTime` int not null,
    primary key(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;