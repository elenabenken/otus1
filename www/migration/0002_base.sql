create table if not exists `goods` (
    `id` int(10) unsigned not null auto_increment,
    `name` varchar(255) not null,
    `price` int(11) not null,
     `category` char(50) not null,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;
 
