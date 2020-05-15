/*==============================================================*/
/* DBMS name:      SAP SQL Anywhere 17                          */
/* Created on:     5/15/2020 5:05:22 PM                         */
/*==============================================================*/


if exists(select 1 from sys.sysforeignkey where role='FK_ACHETER_ACHETER_PRODUIT') then
    alter table ACHETER
       delete foreign key FK_ACHETER_ACHETER_PRODUIT
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_ACHETER_ACHETER2_CLIENT') then
    alter table ACHETER
       delete foreign key FK_ACHETER_ACHETER2_CLIENT
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_CLIENT_ABITE_VILLE') then
    alter table CLIENT
       delete foreign key FK_CLIENT_ABITE_VILLE
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_PRODUIT_APPARTIEN_CATEGORI') then
    alter table PRODUIT
       delete foreign key FK_PRODUIT_APPARTIEN_CATEGORI
end if;

drop index if exists ACHETER.ACHETER_FK;

drop index if exists ACHETER.ACHETER2_FK;

drop index if exists ACHETER.ACHETER_P;

drop table if exists ACHETER;

drop index if exists CATEGORIE_PRODUIT.CATEGORIE_PRODUIT_PK;

drop table if exists CATEGORIE_PRODUIT;

drop index if exists CLIENT.ABITE_FK;

drop index if exists CLIENT.CLIENT_PK;

drop table if exists CLIENT;

drop index if exists PRODUIT.APPARTIENT_FK;

drop index if exists PRODUIT.PRODUIT_PK;

drop table if exists PRODUIT;

drop index if exists VILLE.VILLE_PK;

drop table if exists VILLE;

/*==============================================================*/
/* Table: ACHETER                                               */
/*==============================================================*/
create or replace table ACHETER 
(
   ID_CLIENT            integer                        not null,
   ID_PRODUIT           integer                        not null,
   QUANTITE             integer                        null,
   DATE_ACHTER          date                           null,
   constraint PK_ACHETER primary key clustered (ID_CLIENT, ID_PRODUIT)
);

/*==============================================================*/
/* Index: ACHETER_P                                             */
/*==============================================================*/
create unique clustered index ACHETER_P on ACHETER (
ID_CLIENT ASC,
ID_PRODUIT ASC
);

/*==============================================================*/
/* Index: ACHETER2_FK                                           */
/*==============================================================*/
create index ACHETER2_FK on ACHETER (
ID_CLIENT ASC
);

/*==============================================================*/
/* Index: ACHETER_FK                                            */
/*==============================================================*/
create index ACHETER_FK on ACHETER (
ID_PRODUIT ASC
);

/*==============================================================*/
/* Table: CATEGORIE_PRODUIT                                     */
/*==============================================================*/
create or replace table CATEGORIE_PRODUIT 
(
   ID_CATEGORIE         integer                        not null,
   LIBELLE_CATEGORIE    char(20)                       null,
   constraint PK_CATEGORIE_PRODUIT primary key clustered (ID_CATEGORIE)
);

/*==============================================================*/
/* Index: CATEGORIE_PRODUIT_PK                                  */
/*==============================================================*/
create unique clustered index CATEGORIE_PRODUIT_PK on CATEGORIE_PRODUIT (
ID_CATEGORIE ASC
);

/*==============================================================*/
/* Table: CLIENT                                                */
/*==============================================================*/
create or replace table CLIENT 
(
   ID_CLIENT            integer                        not null,
   ID_VILLE             integer                        not null,
   NOM_CLIENT           char(15)                       null,
   ADRESS_CLIENT        varchar(30)                    null,
   TELE_CLIENT          varchar(10)                    null,
   EMAIL_CLIENT         varchar(30)                    null,
   "LOGIN"              varchar(15)                    null,
   MDP_CLIENT           varchar(10)                    null,
   constraint PK_CLIENT primary key clustered (ID_CLIENT)
);

/*==============================================================*/
/* Index: CLIENT_PK                                             */
/*==============================================================*/
create unique clustered index CLIENT_PK on CLIENT (
ID_CLIENT ASC
);

/*==============================================================*/
/* Index: ABITE_FK                                              */
/*==============================================================*/
create index ABITE_FK on CLIENT (
ID_VILLE ASC
);

/*==============================================================*/
/* Table: PRODUIT                                               */
/*==============================================================*/
create or replace table PRODUIT 
(
   ID_PRODUIT           integer                        not null,
   ID_CATEGORIE         integer                        not null,
   NOM_PRODUIT          char(15)                       null,
   DESCRIPTION_PRODUIT  char(15)                       null,
   PRIX_PRODUIT         decimal                        null,
   constraint PK_PRODUIT primary key clustered (ID_PRODUIT)
);

/*==============================================================*/
/* Index: PRODUIT_PK                                            */
/*==============================================================*/
create unique clustered index PRODUIT_PK on PRODUIT (
ID_PRODUIT ASC
);

/*==============================================================*/
/* Index: APPARTIENT_FK                                         */
/*==============================================================*/
create index APPARTIENT_FK on PRODUIT (
ID_CATEGORIE ASC
);

/*==============================================================*/
/* Table: VILLE                                                 */
/*==============================================================*/
create or replace table VILLE 
(
   ID_VILLE             integer                        not null,
   CP_VILLE             varchar(25)                    null,
   NOM_COMMUNE_VILLE    varchar(20)                    null,
   NOM_REGION_VILLE     varchar(20)                    null,
   constraint PK_VILLE primary key clustered (ID_VILLE)
);

/*==============================================================*/
/* Index: VILLE_PK                                              */
/*==============================================================*/
create unique clustered index VILLE_PK on VILLE (
ID_VILLE ASC
);

alter table ACHETER
   add constraint FK_ACHETER_ACHETER_PRODUIT foreign key (ID_PRODUIT)
      references PRODUIT (ID_PRODUIT)
      on update restrict
      on delete restrict;

alter table ACHETER
   add constraint FK_ACHETER_ACHETER2_CLIENT foreign key (ID_CLIENT)
      references CLIENT (ID_CLIENT)
      on update restrict
      on delete restrict;

alter table CLIENT
   add constraint FK_CLIENT_ABITE_VILLE foreign key (ID_VILLE)
      references VILLE (ID_VILLE)
      on update restrict
      on delete restrict;

alter table PRODUIT
   add constraint FK_PRODUIT_APPARTIEN_CATEGORI foreign key (ID_CATEGORIE)
      references CATEGORIE_PRODUIT (ID_CATEGORIE)
      on update restrict
      on delete restrict;

