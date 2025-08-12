create table clientes(
	id int(6) not null auto_increment,
    nome varchar(30) not null,
    sobrenome varchar(30) not null,
    telefone int(15) not null,
    cpf char(11) not null,
    email varchar(120) not null,
    senha varchar(256) not null,
    data_criacao_conta datetime not null,
    data_nascimento date not null,
    
    primary key(id)
    );
    