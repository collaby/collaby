--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.2
-- Dumped by pg_dump version 9.3.2
-- Started on 2014-02-03 20:00:07 BRT

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 188 (class 3079 OID 11837)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 188
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 189 (class 3079 OID 17606)
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 189
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET search_path = public, pg_catalog;

--
-- TOC entry 235 (class 1255 OID 17640)
-- Name: sha1(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION sha1(bytea) RETURNS character varying
    LANGUAGE plpgsql
    AS $_$
BEGIN
RETURN ENCODE(DIGEST($1, 'sha1'), 'hex');
END;
$_$;


ALTER FUNCTION public.sha1(bytea) OWNER TO postgres;

--
-- TOC entry 236 (class 1255 OID 17641)
-- Name: sha256(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION sha256(bytea) RETURNS character varying
    LANGUAGE plpgsql
    AS $_$
BEGIN
RETURN ENCODE(DIGEST($1, 'sha256'), 'hex');
END;
$_$;


ALTER FUNCTION public.sha256(bytea) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 170 (class 1259 OID 17642)
-- Name: acl_actions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acl_actions (
    id integer NOT NULL,
    action character varying(50) NOT NULL
);


--
-- TOC entry 171 (class 1259 OID 17645)
-- Name: acl_controllers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acl_controllers (
    id integer NOT NULL,
    controller character varying(50) NOT NULL
);


--
-- TOC entry 172 (class 1259 OID 17648)
-- Name: acl_modules; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acl_modules (
    id integer NOT NULL,
    module character varying(50) NOT NULL
);


--
-- TOC entry 173 (class 1259 OID 17651)
-- Name: acl_privileges; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acl_privileges (
    resource_id integer NOT NULL,
    role_id integer NOT NULL,
    allow boolean DEFAULT false NOT NULL
);


--
-- TOC entry 174 (class 1259 OID 17655)
-- Name: acl_resources; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acl_resources (
    id integer NOT NULL,
    module_id integer NOT NULL,
    controller_id integer NOT NULL,
    action_id integer NOT NULL
);


--
-- TOC entry 175 (class 1259 OID 17658)
-- Name: acl_roles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acl_roles (
    id integer NOT NULL,
    role character varying(50) NOT NULL,
    parent integer
);


--
-- TOC entry 176 (class 1259 OID 17661)
-- Name: document_tags; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE document_tags (
    document_id bigint NOT NULL,
    tag_id bigint NOT NULL
);


ALTER TABLE public.document_tags OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 17664)
-- Name: document_templates; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE document_templates (
    document_id bigint NOT NULL,
    original_template_id bigint NOT NULL,
    content text NOT NULL
);


ALTER TABLE public.document_templates OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 17670)
-- Name: document_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE document_types (
    id integer NOT NULL,
    type character varying(20) NOT NULL,
    type_abbr character varying(2) NOT NULL
);


--
-- TOC entry 179 (class 1259 OID 17673)
-- Name: documents; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE documents (
    cloned_from bigint,
    content text,
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    id bigint NOT NULL,
    name character varying(200) NOT NULL,
    owner integer NOT NULL,
    template text,
    updated_at timestamp without time zone,
    updated_by integer,
    url_to_share character varying(2000),
    document_type_id integer NOT NULL
);


--
-- TOC entry 180 (class 1259 OID 17680)
-- Name: documents_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE documents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 180
-- Name: documents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE documents_id_seq OWNED BY documents.id;


--
-- TOC entry 181 (class 1259 OID 17682)
-- Name: tags; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tags (
    id bigint NOT NULL,
    tag character varying(100) NOT NULL
);


ALTER TABLE public.tags OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 17685)
-- Name: tags_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tags_id_seq OWNER TO postgres;

--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 182
-- Name: tags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tags_id_seq OWNED BY tags.id;


--
-- TOC entry 183 (class 1259 OID 17687)
-- Name: templates; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE templates (
    content text NOT NULL,
    description character varying(50) NOT NULL,
    document_type_id integer NOT NULL,
    id bigint NOT NULL
);


ALTER TABLE public.templates OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 17693)
-- Name: templates_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.templates_id_seq OWNER TO postgres;

--
-- TOC entry 2193 (class 0 OID 0)
-- Dependencies: 184
-- Name: templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE templates_id_seq OWNED BY templates.id;


--
-- TOC entry 185 (class 1259 OID 17695)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
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
-- TOC entry 186 (class 1259 OID 17702)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 186
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 1978 (class 2604 OID 28462)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY documents ALTER COLUMN id SET DEFAULT nextval('documents_id_seq'::regclass);


--
-- TOC entry 2011 (class 2604 OID 17711)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tags ALTER COLUMN id SET DEFAULT nextval('tags_id_seq'::regclass);


--
-- TOC entry 2012 (class 2604 OID 17712)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY templates ALTER COLUMN id SET DEFAULT nextval('templates_id_seq'::regclass);


--
-- TOC entry 2014 (class 2604 OID 17713)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 2016 (class 2606 OID 17719)
-- Name: acl_actions_action_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_actions
    ADD CONSTRAINT acl_actions_action_key UNIQUE (action);


--
-- TOC entry 2018 (class 2606 OID 17721)
-- Name: acl_actions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_actions
    ADD CONSTRAINT acl_actions_pkey PRIMARY KEY (id);


--
-- TOC entry 2020 (class 2606 OID 17723)
-- Name: acl_controllers_controller_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_controllers
    ADD CONSTRAINT acl_controllers_controller_key UNIQUE (controller);


--
-- TOC entry 2022 (class 2606 OID 17725)
-- Name: acl_controllers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_controllers
    ADD CONSTRAINT acl_controllers_pkey PRIMARY KEY (id);


--
-- TOC entry 2024 (class 2606 OID 17727)
-- Name: acl_modules_module_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_modules
    ADD CONSTRAINT acl_modules_module_key UNIQUE (module);


--
-- TOC entry 2026 (class 2606 OID 17729)
-- Name: acl_modules_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_modules
    ADD CONSTRAINT acl_modules_pkey PRIMARY KEY (id);


--
-- TOC entry 2028 (class 2606 OID 17731)
-- Name: acl_privileges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_privileges
    ADD CONSTRAINT acl_privileges_pkey PRIMARY KEY (resource_id, role_id);


--
-- TOC entry 2030 (class 2606 OID 17733)
-- Name: acl_resources_module_id_controller_id_action_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_module_id_controller_id_action_id_key UNIQUE (module_id, controller_id, action_id);


--
-- TOC entry 2032 (class 2606 OID 17735)
-- Name: acl_resources_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_pkey PRIMARY KEY (id);


--
-- TOC entry 2034 (class 2606 OID 17737)
-- Name: acl_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT acl_roles_pkey PRIMARY KEY (id);


--
-- TOC entry 2036 (class 2606 OID 17739)
-- Name: acl_roles_role_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT acl_roles_role_key UNIQUE (role);


--
-- TOC entry 2038 (class 2606 OID 17741)
-- Name: document_tags_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY document_tags
    ADD CONSTRAINT document_tags_pkey PRIMARY KEY (document_id, tag_id);


--
-- TOC entry 2040 (class 2606 OID 17743)
-- Name: document_templates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY document_templates
    ADD CONSTRAINT document_templates_pkey PRIMARY KEY (document_id, original_template_id);


--
-- TOC entry 2042 (class 2606 OID 17745)
-- Name: document_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY document_types
    ADD CONSTRAINT document_types_pkey PRIMARY KEY (id);


--
-- TOC entry 2044 (class 2606 OID 17747)
-- Name: documents_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT documents_pkey PRIMARY KEY (id);


--
-- TOC entry 2048 (class 2606 OID 17749)
-- Name: tags_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (id);


--
-- TOC entry 2050 (class 2606 OID 17751)
-- Name: tags_tag_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_tag_key UNIQUE (tag);


--
-- TOC entry 2052 (class 2606 OID 17753)
-- Name: templates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY templates
    ADD CONSTRAINT templates_pkey PRIMARY KEY (id);


--
-- TOC entry 2054 (class 2606 OID 17755)
-- Name: users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 2056 (class 2606 OID 17757)
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2058 (class 2606 OID 17759)
-- Name: users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- TOC entry 2045 (class 1259 OID 17760)
-- Name: index_created_at; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX index_created_at ON documents USING btree (created_at);


--
-- TOC entry 2046 (class 1259 OID 17761)
-- Name: index_updated_at; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX index_updated_at ON documents USING btree (updated_at);


--
-- TOC entry 2059 (class 2606 OID 17762)
-- Name: acl_privileges_resource_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY acl_privileges
    ADD CONSTRAINT acl_privileges_resource_id_fkey FOREIGN KEY (resource_id) REFERENCES acl_resources(id);


--
-- TOC entry 2060 (class 2606 OID 17767)
-- Name: acl_privileges_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY acl_privileges
    ADD CONSTRAINT acl_privileges_role_id_fkey FOREIGN KEY (role_id) REFERENCES acl_roles(id);


--
-- TOC entry 2061 (class 2606 OID 17772)
-- Name: acl_resources_action_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_action_id_fkey FOREIGN KEY (action_id) REFERENCES acl_actions(id);


--
-- TOC entry 2062 (class 2606 OID 17777)
-- Name: acl_resources_controller_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_controller_id_fkey FOREIGN KEY (controller_id) REFERENCES acl_controllers(id);


--
-- TOC entry 2063 (class 2606 OID 17782)
-- Name: acl_resources_module_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY acl_resources
    ADD CONSTRAINT acl_resources_module_id_fkey FOREIGN KEY (module_id) REFERENCES acl_modules(id);


--
-- TOC entry 2064 (class 2606 OID 17787)
-- Name: acl_roles_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY acl_roles
    ADD CONSTRAINT acl_roles_parent_fkey FOREIGN KEY (parent) REFERENCES acl_roles(id);


--
-- TOC entry 2065 (class 2606 OID 17792)
-- Name: document_tags_document_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY document_tags
    ADD CONSTRAINT document_tags_document_id_fkey FOREIGN KEY (document_id) REFERENCES documents(id);


--
-- TOC entry 2066 (class 2606 OID 17797)
-- Name: document_tags_tag_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY document_tags
    ADD CONSTRAINT document_tags_tag_id_fkey FOREIGN KEY (tag_id) REFERENCES tags(id);


--
-- TOC entry 2074 (class 2606 OID 17802)
-- Name: lnk_acl_roles_users; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT lnk_acl_roles_users FOREIGN KEY (acl_roles_id) REFERENCES acl_roles(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2069 (class 2606 OID 17807)
-- Name: lnk_document_types_documents; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_document_types_documents FOREIGN KEY (document_type_id) REFERENCES document_types(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2073 (class 2606 OID 17812)
-- Name: lnk_document_types_templates; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY templates
    ADD CONSTRAINT lnk_document_types_templates FOREIGN KEY (document_type_id) REFERENCES document_types(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2067 (class 2606 OID 17817)
-- Name: lnk_documents_MM_templates; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY document_templates
    ADD CONSTRAINT "lnk_documents_MM_templates" FOREIGN KEY (document_id) REFERENCES documents(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2070 (class 2606 OID 17822)
-- Name: lnk_documents_documents; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_documents_documents FOREIGN KEY (cloned_from) REFERENCES documents(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2068 (class 2606 OID 17827)
-- Name: lnk_templates_MM_documents; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY document_templates
    ADD CONSTRAINT "lnk_templates_MM_documents" FOREIGN KEY (original_template_id) REFERENCES templates(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2071 (class 2606 OID 17832)
-- Name: lnk_users_documents; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_users_documents FOREIGN KEY (owner) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2072 (class 2606 OID 17837)
-- Name: lnk_users_documents_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY documents
    ADD CONSTRAINT lnk_users_documents_1 FOREIGN KEY (updated_by) REFERENCES users(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-02-03 20:00:07 BRT

--
-- PostgreSQL database dump complete
--

