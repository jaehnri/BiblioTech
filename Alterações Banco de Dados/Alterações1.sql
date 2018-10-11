select * from Usuario



create table Tipo (
codTipo int identity(1,1) primary key,
nome varchar(50) not null
)

delete from Material

delete from Categoria

alter table Categoria drop column tipo
alter table Categoria add codTipo int not null
alter table Categoria add constraint fkCodTipo foreign key (codTipo) references Tipo (codTipo) 

insert into Tipo values ('M�dio')
insert into Tipo values ('Inform�tica')

insert into Categoria values ('Portugu�s', 1)
insert into Categoria values ('Biologia', 1)
insert into Categoria values ('Artes', 1)
insert into Categoria values ('Matem�tica', 1)
insert into Categoria values ('Ingl�s', 1)
insert into Categoria values ('Educa��o F�sica', 1)
insert into Categoria values ('F�sica', 1)

SELECT c.codCategoria, c.nome, c.codTipo FROM Categoria c, Tipo t where c.codtipo = t.codTipo AND c.codTipo = Medio order by c.nome

dbcc checkident ('categoria', reseed, 0)

select * from Categoria
select * from Tipo