CREATE TABLE Candidato (
    idcandidato INTEGER PRIMARY KEY,
    nomeCandidato VARCHAR,
    cpfCandidato VARCHAR,
    numCandidatura VARCHAR,
    rgCandidato VARCHAR,
    statusCandidato VARCHAR,
    fk_Candidato_instituicao INTEGER
);

CREATE TABLE Concurso (
    idConcurso INTEGER PRIMARY KEY,
    nomeCurso VARCHAR,
    dataConcurso DATE
);

CREATE TABLE Cargos (
    idCargo INTEGER PRIMARY KEY,
    tipoCargo VARCHAR,
    nomeCargo VARCHAR
);

CREATE TABLE Departamentos (
    idDepartamento INTEGER PRIMARY KEY,
    nomeDepartamento VARCHAR
);

CREATE TABLE Instituicao (
    idInstituicao INTEGER PRIMARY KEY,
    nomeInstituicao VARCHAR,
    cnpjInstituicao VARCHAR
);

CREATE TABLE endereco(
    idEnd int(11)PRIMARY KEY IDENTITY,
    rua varchar(150),
    bairro VARCHAR(150),
    estado VARCHAR(10),
    CEP INT(110),
    numero int(100)
);

CREATE TABLE Candidato_Concurso (
    fk_Candidato_idcandidato INTEGER,
    fk_Concurso_idConcurso INTEGER
);

CREATE TABLE Cargos_Concurso (
    fk_Cargos_idCargo INTEGER,
    fk_Concurso_idConcurso INTEGER
);

CREATE TABLE Departamentos_Cargos (
    fk_Departamentos_idDepartamento INTEGER,
    fk_Cargos_idCargo INTEGER
);

CREATE TABLE Instituicao_Concurso (
    fk_Instituicao_idInstituicao INTEGER,
    fk_Concurso_idConcurso INTEGER
);
 
ALTER TABLE Candidato ADD CONSTRAINT FK_Candidato_2
    FOREIGN KEY (fk_Candidato_instituicao)
    REFERENCES candidato (idcandidato);
 
ALTER TABLE Candidato_Concurso ADD CONSTRAINT FK_Candidato_Concurso_1
    FOREIGN KEY (fk_Candidato_idcandidato)
    REFERENCES Candidato (idcandidato)
    ;
 
ALTER TABLE Candidato_Concurso ADD CONSTRAINT FK_Candidato_Concurso_2
    FOREIGN KEY (fk_Concurso_idConcurso)
    REFERENCES Concurso (idConcurso)
    ;
 
ALTER TABLE Cargos_Concurso ADD CONSTRAINT FK_Cargos_Concurso_1
    FOREIGN KEY (fk_Cargos_idCargo)
    REFERENCES Cargos (idCargo)
    ;
 
ALTER TABLE Cargos_Concurso ADD CONSTRAINT FK_Cargos_Concurso_2
    FOREIGN KEY (fk_Concurso_idConcurso)
    REFERENCES Concurso (idConcurso)
    ;
 
ALTER TABLE Departamentos_Cargos ADD CONSTRAINT FK_Departamentos_Cargos_1
    FOREIGN KEY (fk_Departamentos_idDepartamento)
    REFERENCES Departamentos (idDepartamento)
    ;
 
ALTER TABLE Departamentos_Cargos ADD CONSTRAINT FK_Departamentos_Cargos_2
    FOREIGN KEY (fk_Cargos_idCargo)
    REFERENCES Cargos (idCargo)
    ;
 
ALTER TABLE Instituicao_Concurso ADD CONSTRAINT FK_Instituicao_Concurso_1
    FOREIGN KEY (fk_Instituicao_idInstituicao)
    REFERENCES Instituicao (idInstituicao)
    ;
 
ALTER TABLE Instituicao_Concurso ADD CONSTRAINT FK_Instituicao_Concurso_2
    FOREIGN KEY (fk_Concurso_idConcurso)
    REFERENCES Concurso (idConcurso)
    ;