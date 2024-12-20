--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.10
-- Dumped by pg_dump version 9.6.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: _categories; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._categories (
    id smallint,
    "position" character varying(10) DEFAULT NULL::character varying,
    user_id smallint
);


ALTER TABLE public._categories OWNER TO rebasedata;

--
-- Name: _comments; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._comments (
    player_id smallint,
    comment_text character varying(17) DEFAULT NULL::character varying,
    category_id smallint,
    comment_id smallint,
    commenter_name character varying(8) DEFAULT NULL::character varying
);


ALTER TABLE public._comments OWNER TO rebasedata;

--
-- Name: _football_legends; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._football_legends (
    player_id smallint,
    first_name character varying(9) DEFAULT NULL::character varying,
    last_name character varying(20) DEFAULT NULL::character varying,
    category_id smallint,
    goals smallint,
    appearances smallint,
    images character varying(26) DEFAULT NULL::character varying,
    created_at character varying(19) DEFAULT NULL::character varying,
    updated_at character varying(19) DEFAULT NULL::character varying
);


ALTER TABLE public._football_legends OWNER TO rebasedata;

--
-- Name: _user; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._user (
    user_id smallint,
    name character varying(6) DEFAULT NULL::character varying,
    password character varying(60) DEFAULT NULL::character varying,
    email character varying(24) DEFAULT NULL::character varying,
    role smallint,
    date character varying(19) DEFAULT NULL::character varying
);


ALTER TABLE public._user OWNER TO rebasedata;

--
-- Data for Name: _categories; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._categories (id, "position", user_id) FROM stdin;
11	Forward	0
12	Midfielder	0
13	Defender	0
\.


--
-- Data for Name: _comments; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._comments (player_id, comment_text, category_id, comment_id, commenter_name) FROM stdin;
30	boss	11	3	toy
22	fecrc	11	6	pomo
22	fecrc	11	7	pomo
22	hey babe	11	29	hi
25	danger	11	30	eden
25	danger	11	31	eden
29	zizou	12	32	zine
29	zizou	12	33	zine
26	legend	12	34	la masia
26	legend	12	35	la masia
34	SIIIIUUUUUUUUUUUU	11	36	ororo
34	SIIIIUUUUUUUUUUUU	11	37	ororo
35	how are you	11	38	taylor
35	how are you	11	39	taylor
\.


--
-- Data for Name: _football_legends; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._football_legends (player_id, first_name, last_name, category_id, goals, appearances, images, created_at, updated_at) FROM stdin;
23	Paolo	Maldini	13	30	1027	images/Maldini.jpg	2023-12-09 06:43:54	2023-12-09 06:43:54
24	diego	Maradona	12	344	160	images/diego-maradona1.jpg	2023-12-09 06:44:52	2023-12-09 06:44:52
25	Eden	Harzard	11	167	620	images/eden harzaed.png	2023-12-09 06:45:52	2023-12-09 06:45:52
26	andres	Iniesta	12	89	867	images/iniesta.jpeg	2023-12-09 06:47:10	2023-12-09 06:47:10
27	frank	lampard	12	898	265	images/lampard.jpg	2023-12-09 06:47:51	2023-12-09 06:47:51
28	ronaldo	Nazario	11	298	454	images/r9.jpg	2023-12-09 06:50:02	2023-12-09 06:50:02
29	Zinedine 	Zidane	12	124	689	images/zidane.jpg	2023-12-09 06:50:42	2023-12-09 06:50:42
32	Lionel	Messi	11	900	1166	images/lionel-messi.jpg	2024-04-15 05:23:34	2024-04-15 05:23:34
33	Didier	Drogba	11	398	689	images/Drogba.jpg	2024-04-15 05:24:07	2024-04-15 05:24:07
34	Cristiano	Ronaldo	11	1009	1398	images/cr7.webp	2024-04-15 05:24:54	2024-04-15 05:24:54
35	Pele 	Edson  do Nascimento	11	1000	898	images/pele.webp	2024-04-15 05:27:45	2024-04-15 05:27:45
\.


--
-- Data for Name: _user; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._user (user_id, name, password, email, role, date) FROM stdin;
11	toyyib	$2y$10$dymZ4D0mWQgDmLiIPo2G9.FAWL9P0UwU056u1tBUq82i4CWF7d81y	taiyeolabamiji@gmail.com	0	2023-12-09 05:49:33
12	xrae	$2y$10$fF39H5eoNE01Ls/3vj/OReNEcbPSwm.1tYrerWpCCbdPm0lA12rYi	dshdeb@eimail.com	1	2023-12-09 05:50:27
17	daniel	$2y$10$oTfXPmLUO1s16D6ye3tET.jftfCP5jpeBhgGg/ui52bA/LwKZ7Hv6	toyyib@djle.com	1	2024-04-15 01:22:54
18	mateen	$2y$10$vPzEulbvWkekl7wST5sIK./SNqOe0Upb9Io6Scmk6rl3tBlCOUhsm	toyyib@djle.com	0	2024-04-15 04:56:50
\.


--
-- PostgreSQL database dump complete
--

