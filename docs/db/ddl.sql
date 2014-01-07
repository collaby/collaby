--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.2
-- Dumped by pg_dump version 9.3.2
-- Started on 2014-01-04 18:57:12 BRT

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 175 (class 1259 OID 28250)
-- Name: acl_actions; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_actions (
    id integer NOT NULL,
    action character varying(50) NOT NULL
);


--
-- TOC entry 174 (class 1259 OID 28243)
-- Name: acl_controllers; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_controllers (
    id integer NOT NULL,
    controller character varying(50) NOT NULL
);


--
-- TOC entry 173 (class 1259 OID 28236)
-- Name: acl_modules; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_modules (
    id integer NOT NULL,
    module character varying(50) NOT NULL
);


--
-- TOC entry 177 (class 1259 OID 28318)
-- Name: acl_privileges; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_privileges (
    resource_id integer NOT NULL,
    role_id integer NOT NULL,
    allow boolean DEFAULT false NOT NULL
);


--
-- TOC entry 176 (class 1259 OID 28296)
-- Name: acl_resources; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_resources (
    id integer NOT NULL,
    module_id integer NOT NULL,
    controller_id integer NOT NULL,
    action_id integer NOT NULL
);


--
-- TOC entry 172 (class 1259 OID 28229)
-- Name: acl_roles; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_roles (
    id integer NOT NULL,
    role character varying(50) NOT NULL,
    parent integer
);


--
-- TOC entry 179 (class 1259 OID 28449)
-- Name: document_types; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE document_types (
    id integer NOT NULL,
    type character varying(20) NOT NULL
);


--
-- TOC entry 181 (class 1259 OID 28458)
-- Name: documents; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE documents (
    cloned_from bigint,
    content text,
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    id bigint NOT NULL,
    name character varying(200) NOT NULL,
    owner integer NOT NULL,
    template text NOT NULL,
    updated_at timestamp without time zone,
    updated_by integer,
    url_to_share character varying(2000),
    document_type_id integer NOT NULL
);


--
-- TOC entry 180 (class 1259 OID 28456)
-- Name: documents_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE documents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2133 (class 0 OID 0)
-- Dependencies: 180
-- Name: documents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE documents_id_seq OWNED BY documents.id;


--
-- TOC entry 171 (class 1259 OID 28221)
-- Name: users; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    username character varying(20) NOT NULL,
    password character varying(64) NOT NULL,
    acl_roles_id integer NOT NULL,
    email character varying(150) NOT NULL,
    real_name character varying(200) NOT NULL,
    verified boolean DEFAULT false NOT NULL,
    verifying_hash character varying(64) NOT NULL
);


--
-- TOC entry 170 (class 1259 OID 28219)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2134 (class 0 OID 0)
-- Dependencies: 170
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 1978 (class 2604 OID 28462)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY documents ALTER COLUMN id SET DEFAULT nextval('documents_id_seq'::regclass);


--
-- TOC entry 1974 (class 2604 OID 28224)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 1998 (class 2606 OID 28256)
-- Name: acl_actions_action_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_actions
    ADD CONSTRAINT acl_actions_action_key UNIQUE (action);


--
-- TOC entry 2000 (class 2606 OID 28254)
-- Name: acl_actions_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_actions
    ADD CONSTRAINT acl_actions_pkey PRIMARY KEY (id);


--
-- TOC entry 1994 (class 2606 OID 28249)
-- Name: acl_controllers_controller_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_controllers
    ADD CONSTRAINT acl_controllers_controller_key UNIQUE (controller);


--
-- TOC entry 1996 (class 2606 OID 28247)
-- Name: acl_controllers_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_controllers
    ADD CONSTRAINT acl_controllers_pkey PRIMARY KEY (id);


--
-- TOC entry 1990 (class 2606 OID 28242)
-- Name: acl_modules_module_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_modules
    ADD CONSTRAINT acl_modules_module_key UNIQUE (module);


--
-- TOC entry 1992 (class 2606 OID 28240)
-- Name: acl_modules_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_modules
    ADD CONSTRAINT acl_modules_pkey PRIMARY KEY (id);


--
-- TOC entry 2006 (class 2606 OID 28323)
-- Name: acl_privileges_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_privileges
    ADD CONSTRAINT acl_privileges_pkey PRIMARY KEY (resource_id, role_id);


--
-- TOC entry 2002 (class 2606 OID 28302)
-- Name: acl_resources_module_id_controller_id_action_id_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_module_id_controller_id_action_id_key UNIQUE (module_id, controller_id, action_id);


--
-- TOC entry 2004 (class 2606 OID 28300)
-- Name: acl_resources_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_pkey PRIMARY KEY (id);


--
-- TOC entry 1986 (class 2606 OID 28233)
-- Name: acl_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT acl_roles_pkey PRIMARY KEY (id);


--
-- TOC entry 1988 (class 2606 OID 28235)
-- Name: acl_roles_role_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT acl_roles_role_key UNIQUE (role);


--
-- TOC entry 2008 (class 2606 OID 28471)
-- Name: document_types_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY document_types
    ADD CONSTRAINT document_types_pkey PRIMARY KEY (id);


--
-- TOC entry 2010 (class 2606 OID 28467)
-- Name: documents_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT documents_pkey PRIMARY KEY (id);


--
-- TOC entry 1980 (class 2606 OID 28410)
-- Name: users_email_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 1982 (class 2606 OID 28226)
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 1984 (class 2606 OID 28228)
-- Name: users_username_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- TOC entry 2016 (class 2606 OID 28324)
-- Name: acl_privileges_resource_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_privileges
    ADD CONSTRAINT acl_privileges_resource_id_fkey FOREIGN KEY (resource_id) REFERENCES acl_resources(id);


--
-- TOC entry 2017 (class 2606 OID 28329)
-- Name: acl_privileges_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_privileges
    ADD CONSTRAINT acl_privileges_role_id_fkey FOREIGN KEY (role_id) REFERENCES acl_roles(id);


--
-- TOC entry 2015 (class 2606 OID 28313)
-- Name: acl_resources_action_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_action_id_fkey FOREIGN KEY (action_id) REFERENCES acl_actions(id);


--
-- TOC entry 2014 (class 2606 OID 28308)
-- Name: acl_resources_controller_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_controller_id_fkey FOREIGN KEY (controller_id) REFERENCES acl_controllers(id);


--
-- TOC entry 2013 (class 2606 OID 28303)
-- Name: acl_resources_module_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_module_id_fkey FOREIGN KEY (module_id) REFERENCES acl_modules(id);


--
-- TOC entry 2012 (class 2606 OID 28334)
-- Name: acl_roles_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT acl_roles_parent_fkey FOREIGN KEY (parent) REFERENCES acl_roles(id);


--
-- TOC entry 2011 (class 2606 OID 28496)
-- Name: lnk_acl_roles_users; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY users
    ADD CONSTRAINT lnk_acl_roles_users FOREIGN KEY (acl_roles_id) REFERENCES acl_roles(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2018 (class 2606 OID 28472)
-- Name: lnk_document_types_documents; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_document_types_documents FOREIGN KEY (document_type_id) REFERENCES document_types(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2019 (class 2606 OID 28477)
-- Name: lnk_documents_documents; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_documents_documents FOREIGN KEY (cloned_from) REFERENCES documents(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2020 (class 2606 OID 28484)
-- Name: lnk_users_documents; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_users_documents FOREIGN KEY (owner) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2021 (class 2606 OID 28491)
-- Name: lnk_users_documents_1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_users_documents_1 FOREIGN KEY (updated_by) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


-- Completed on 2014-01-04 18:57:13 BRT

--
-- PostgreSQL database dump complete
--

