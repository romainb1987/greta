CREATE TABLE Theme (
  idTheme INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  code_theme VARCHAR(45) NULL,
  Nom_theme VARCHAR(255) NULL,
  couleur_th VARCHAR(45) NULL,
  etat_th VARCHAR(45) NULL,
  constraint pk_themes PRIMARY KEY(idTheme)
);

CREATE TABLE Formateurs (
  idFormateurs INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  code_formateur VARCHAR(45) NULL,
  nom_form VARCHAR(255) NULL,
  prenom_form VARCHAR(255) NULL,
  adr_form VARCHAR(255) NULL,
  log_form VARCHAR(255) NULL,
  mdp_form VARCHAR(255) NULL,
  etat_form VARCHAR(45) NULL,
  constraint pk_formateurs PRIMARY KEY(idFormateurs)
);

CREATE TABLE Stagiaire (
  idStagiaire INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  code_stagiaire VARCHAR(45) NULL,
  nom_stagiaire VARCHAR(45) NULL,
  prenom_stagiaire VARCHAR(45) NULL,
  log_stagiaire VARCHAR(45) NULL,
  mdp_stagiaire VARCHAR(45) NULL,
  constraint pk_stagiaires PRIMARY KEY(idStagiaire)
);
);

CREATE TABLE Matiere (
  idMatiere INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  code_matiere INTEGER UNSIGNED NULL,
  Nom_Matiere VARCHAR(45) NULL,
  constraint pk_matiere PRIMARY KEY(idMatiere)
);

CREATE TABLE admin (
  idadmin INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  MDP_admin VARCHAR(45) NULL,
  constraint pk_admin PRIMARY KEY(idadmin)
);

CREATE TABLE Admin_parcours (
  idAdmin_parcours INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  code_adminparc VARCHAR(45) NULL,
  Nom_adminparc VARCHAR(45) NULL,
  Prenom_adminparc VARCHAR(45) NULL, 
  log_adminparc VARCHAR(45) NULL,
  mdp_adminparc VARCHAR(45) NULL,
  constraint pk_adparc PRIMARY KEY(idAdmin_parcours)
);

CREATE TABLE Competence (
  idCompetence INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Nom_Comp VARCHAR(255) NULL,
  Desc_Comp VARCHAR(255) NULL,
  Code_Comp VARCHAR(255) NULL,
  constraint pk_comp PRIMARY KEY(idCompetence)
);

CREATE TABLE Date (
  idDate DATETIME NOT NULL,
  constraint pk_date PRIMARY KEY(idDate)
);

CREATE TABLE Type_Formation (
  idType_Form INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nom_typeForm VARCHAR(45) NULL,
  constraint pk_typeformation PRIMARY KEY(idType_Form)
);

CREATE TABLE Image (
  idImage INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idStagiaire INTEGER UNSIGNED NOT NULL,
  nomimg VARCHAR(255) NULL,
  tailleimg VARCHAR(20) NULL,
  typeimg VARCHAR(45) NULL,
  descimg VARCHAR(255) NULL,
  img BLOB NULL,
  constraint pk_img PRIMARY KEY(idImage),
  constraint fk_stag_idstag FOREIGN KEY(idStagiaire)
    REFERENCES Stagiaire(idStagiaire)
);

CREATE TABLE Formation (
  idFormation INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idType_Form INTEGER UNSIGNED NOT NULL,
  idAdmin_parcours INTEGER UNSIGNED NOT NULL,
  idFormateurs INTEGER NULL,
  nom_Form VARCHAR(45) NULL,
  desc_Form VARCHAR(255) NULL,
  etat_Form VARCHAR(45) NULL,
  code_Form VARCHAR(45) NULL,
  constraint pk_form PRIMARY KEY(idFormation),
  FOREIGN KEY(idType_Form)
    REFERENCES Type_Formation(idType_Form),
  FOREIGN KEY(idAdmin_parcours)
    REFERENCES Admin_parcours(idAdmin_parcours),
  FOREIGN KEY(idFormateurs)
    REFERENCES Formateurs(idFormateurs)idFormateurs
);

CREATE TABLE Parcours (
  idParcours INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idFormation INTEGER UNSIGNED NOT NULL,
  idStagiaire INTEGER UNSIGNED NOT NULL,
  Date_Deb_Parcours DATE NULL,
  Date_Fin_Parc DATE NULL,
  PRIMARY KEY(idParcours),
  FOREIGN KEY(idStagiaire)
    REFERENCES Stagiaire(idStagiaire),
  FOREIGN KEY(idFormation)
    REFERENCES Formation(idFormation)
);

CREATE TABLE Modules (
  idModules INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idCompetence INTEGER UNSIGNED NOT NULL,
  idMatiere INTEGER UNSIGNED NOT NULL,
  idTheme INTEGER UNSIGNED NOT NULL,
  idFormateurs_suivi INTEGER UNSIGNED NULL,
  idFormateurs_createur INTEGER UNSIGNED NOT NULL,
  idParcours INTEGER UNSIGNED NULL,
  Nom_mod VARCHAR(45) NULL,
  descript_mod VARCHAR(255) NULL,
  etat_mod VARCHAR(45) NULL,
  heure_mod INTEGER UNSIGNED NULL,
  code_module VARCHAR(45) NULL,
  Mod_referentiel BOOL NOT NULL DEFAULT FALSE,
  PRIMARY KEY(idModules),
  FOREIGN KEY(idFormateurs_suivi)
    REFERENCES Formateurs(idFormateurs),
  FOREIGN KEY(idFormateurs_createur)
    REFERENCES Formateurs(idFormateurs),
  FOREIGN KEY(idTheme)
    REFERENCES Theme(idTheme),
  FOREIGN KEY(idMatiere)
    REFERENCES Matiere(idMatiere),
  FOREIGN KEY(idCompetence)
    REFERENCES Competence(idCompetence),
  FOREIGN KEY(idParcours)
    REFERENCES Parcours(idParcours)
);

CREATE TABLE Detail (
  id_Detail INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  code_Detail VARCHAR(45) NULL, 
  Nom_Detail VARCHAR(45) NULL,
  descript_Detail VARCHAR(255) NULL,
  etat_Detail VARCHAR(45) NULL,
  objectif_Detail VARCHAR(255) NULL,
  heure_Detail INTEGER UNSIGNED NULL,
  evaluable BOOL NULL,
  idModules INTEGER UNSIGNED NULL,
  idTheme INTEGER UNSIGNED NOT NULL,
  Mod_detail BOOL NOT NULL DEFAULT FALSE,
  constraint pk_detail PRIMARY KEY(id_Detail),
  FOREIGN KEY(idModules)
    REFERENCES Modules(idModules),  
  FOREIGN KEY(idTheme)
    REFERENCES theme(idTheme)
);

CREATE TABLE detail_module (
  idModules INTEGER UNSIGNED NOT NULL,
  id_Detail INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idModules, id_Detail),
  FOREIGN KEY(idModules)
    REFERENCES Modules(idModules),
  FOREIGN KEY(id_Detail)
    REFERENCES Detail(id_Detail)
);

CREATE TABLE contenu_parcours (
  idModules INTEGER UNSIGNED NOT NULL,
  idFormation INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idModules, idFormation),
  FOREIGN KEY(idFormation)
    REFERENCES Formation(idFormation),
  FOREIGN KEY(idModules)
    REFERENCES Modules(idModules)
);

CREATE TABLE Suivit_Quotidien (
  idParcours INTEGER UNSIGNED NOT NULL,
  id_Detail INTEGER UNSIGNED NOT NULL,
  idDate DATETIME NOT NULL,
  Nbre_heure INTEGER UNSIGNED NULL,
  Commentaire_eleve VARCHAR(255) NULL,
  PRIMARY KEY(idParcours, id_Detail, idDate),
  FOREIGN KEY(idParcours)
    REFERENCES Parcours(idParcours),
  FOREIGN KEY(id_Detail)
    REFERENCES Detail(id_Detail),
  FOREIGN KEY(idDate)
    REFERENCES Date(idDate)
);

CREATE TABLE Suivit_Peda (
  idParcours INTEGER UNSIGNED NOT NULL,
  id_Detail INTEGER UNSIGNED NOT NULL,
  Commentaire VARCHAR(255) NULL,
  Date_Eval DATE NULL,
  Eval SMALLINT UNSIGNED NULL,
  Date_Reeval DATE NULL,
  Reeval SMALLINT UNSIGNED NULL,
  Etat VARCHAR(20) NULL,
  PRIMARY KEY(idParcours, id_Detail),
  FOREIGN KEY(idParcours)
    REFERENCES Parcours(idParcours),
  FOREIGN KEY(id_Detail)
    REFERENCES Detail(id_Detail)
);


