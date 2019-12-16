create table `pushes` (
`id` smallint not null primary key auto_increment,
`name` char(50) default 'no name',
`value` char(100) not null
)