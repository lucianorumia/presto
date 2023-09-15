-- DB creation

DROP DATABASE IF EXISTS presto;
CREATE DATABASE presto
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
USE presto;


-- Tables structure

CREATE TABLE user_roles (
    id tinyint UNSIGNED NOT NULL,
    role varchar(20) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE users (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(8) NOT NULL UNIQUE,
    pass varchar(127) NOT NULL,
    email varchar(63) NOT NULL UNIQUE,
    role_id tinyint UNSIGNED NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_users_role
        FOREIGN KEY (role_id)
        REFERENCES user_roles (id)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE asientos (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    nro int(10) UNSIGNED NOT NULL,
    fecha date NOT NULL,
    concepto varchar(255) NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_by int UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_asientos_created_by
        FOREIGN KEY (created_by)
        REFERENCES users (id)
) ENGINE=InnoDB;

CREATE TABLE cuentas (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    cod mediumint(6) NOT NULL UNIQUE,
    denom varchar(63) NOT NULL,
    imputable tinyint(1) NOT NULL DEFAULT '1',
    stock tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
    ) ENGINE=InnoDB;

    CREATE TABLE minutas (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    asiento_id int UNSIGNED NOT NULL,
    cuenta_id int UNSIGNED NOT NULL,
    debe decimal(11,2) DEFAULT NULL,
    haber decimal(11,2) DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_minutas_asiento
        FOREIGN KEY (asiento_id)
        REFERENCES asientos (id)
        ON DELETE CASCADE,
    CONSTRAINT fk_minutas_cuenta
        FOREIGN KEY (cuenta_id) 
        REFERENCES cuentas (id)
) ENGINE=InnoDB;

CREATE TABLE documento_types (
    id tinyint(1) UNSIGNED NOT NULL,
    type varchar(4) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE personas (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre varchar(63) NOT NULL,
    apellido varchar(63) NOT NULL,
    documento_type_id tinyint(1) UNSIGNED,
    documento_nro varchar(11),
    fecha_nac date,
    obs varchar(255),
    PRIMARY KEY (id),
    CONSTRAINT fk_personas_documento_type
        FOREIGN KEY (documento_type_id) 
        REFERENCES documento_types (id)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE telefono_types (
    id tinyint(1) UNSIGNED NOT NULL,
    type varchar(31) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE telefonos (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    persona_id int UNSIGNED NOT NULL,
    numero varchar(15) NOT NULL,
    type_id tinyint(1) UNSIGNED NOT NULL,
    principal tinyint(1),
    PRIMARY KEY (id),
    CONSTRAINT fk_telefonos_persona
        FOREIGN KEY (persona_id) 
        REFERENCES personas (id),
    CONSTRAINT fk_telefonos_type
        FOREIGN KEY (type_id) 
        REFERENCES telefono_types (id)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE email_types (
    id tinyint(1) UNSIGNED NOT NULL,
    type varchar(15) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE emails (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    persona_id int UNSIGNED NOT NULL,
    email varchar(63) NOT NULL,
    type_id tinyint(1) UNSIGNED NOT NULL,
    principal tinyint(1),
    PRIMARY KEY (id),
    CONSTRAINT fk_emails_persona
        FOREIGN KEY (persona_id) 
        REFERENCES personas (id),
    CONSTRAINT fk_emails_type
        FOREIGN KEY (type_id) 
        REFERENCES email_types (id)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE domicilio_types (
    id tinyint(1) UNSIGNED NOT NULL,
    type varchar(15) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE domicilios (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    persona_id int UNSIGNED NOT NULL,
    calle varchar(63) NOT NULL,
    numero smallint UNSIGNED NOT NULL,
    piso tinyint UNSIGNED,
    dpto varchar(7),
    barrio varchar(63),
    localidad varchar(63),
    cp varchar(15),
    type_id tinyint(1) UNSIGNED NOT NULL,
    principal tinyint(1),
    PRIMARY KEY (id),
    CONSTRAINT fk_domicilios_persona
        FOREIGN KEY (persona_id) 
        REFERENCES personas (id),
    CONSTRAINT fk_domicilios_type
        FOREIGN KEY (type_id) 
        REFERENCES domicilio_types (id)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE clientes (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    persona_id int UNSIGNED NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_by int UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_clientes_persona
        FOREIGN KEY (persona_id) 
        REFERENCES personas (id)
) ENGINE=InnoDB;

CREATE TABLE modalidades (
    id tinyint UNSIGNED NOT NULL,
    modalidad varchar(31) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE periodicidades (
    id tinyint UNSIGNED NOT NULL,
    periodicidad varchar(15) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE prestamos (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    cod int(10) NOT NULL UNIQUE,
    cliente_id int UNSIGNED NOT NULL,
    modalidad_id tinyint(3) UNSIGNED NOT NULL,
    periodicidad_id tinyint(3) UNSIGNED NOT NULL,
    tasa float NOT NULL,
    asiento_id int UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_prestamos_cliente
        FOREIGN KEY (cliente_id)
        REFERENCES clientes (id),
    CONSTRAINT fk_prestamos_modalidad
        FOREIGN KEY (modalidad_id)
        REFERENCES modalidades (id)
        ON UPDATE CASCADE,
    CONSTRAINT fk_prestamos_periodicidad
        FOREIGN KEY (periodicidad_id)
        REFERENCES periodicidades (id)
        ON UPDATE CASCADE,
    CONSTRAINT fk_prestamos_asiento
        FOREIGN KEY (asiento_id)
        REFERENCES asientos (id)
) ENGINE=InnoDB;

CREATE TABLE cuotas (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    prestamo_id int UNSIGNED NOT NULL,
    cod varchar(7) NOT NULL,
    capital decimal(11,2) NOT NULL,
    interes decimal(8,2) NOT NULL,
    fecha_vto date NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_cuotas_prestamo
        FOREIGN KEY (prestamo_id)
        REFERENCES prestamos(id)
) ENGINE=InnoDB;

CREATE TABLE cuota_actions (
    id tinyint(1) UNSIGNED NOT NULL,
    action varchar(14) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE cuotas_actions (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    cuota_id int UNSIGNED NOT NULL,
    action_id tinyint(1) UNSIGNED NOT NULL,
    asiento_id int UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_cuotas_actions_cuota
        FOREIGN KEY (cuota_id)
        REFERENCES cuotas (id),
    CONSTRAINT fk_cuotas_actions_action
        FOREIGN KEY (action_id)
        REFERENCES cuota_actions (id),
    CONSTRAINT fk_cuotas_actions_asiento
        FOREIGN KEY (asiento_id)
        REFERENCES asientos (id)
) ENGINE=InnoDB;

CREATE TABLE cuota_states (
    id tinyint(1) UNSIGNED NOT NULL,
    state varchar(13) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE prestamo_states (
    id tinyint(1) UNSIGNED NOT NULL,
    state varchar(13) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB;


-- Views

CREATE VIEW clientes_list AS (
    SELECT c.id, concat(p.nombre, ' ', p.apellido) AS denominacion, t.numero AS telefono
    FROM personas AS p
    JOIN clientes AS c ON p.id = c.persona_id
    LEFT JOIN (
        SELECT numero, persona_id
        FROM telefonos
        WHERE principal = 1
    ) AS t ON p.id = t.persona_id
    ORDER BY denominacion
);

CREATE VIEW cuotas_state AS (
    SELECT id AS cuota_id,
        CASE
            WHEN precedent_action IN (2, 3, 4, 5) THEN precedent_action
            WHEN fecha_vto < CURRENT_DATE() THEN 1
            ELSE 0
        END AS state_id
    FROM (
        SELECT
            c.id,
            c.fecha_vto,
            MAX(ca.action_id) AS precedent_action
        FROM cuotas AS c
        LEFT JOIN cuotas_actions AS ca ON c.id = ca.cuota_id
        GROUP BY c.id
    ) as sq
)

CREATE VIEW cuotas_list AS (
    SELECT c.id,
        c.prestamo_id,
        c.cod,
        c.fecha_vto,
        c.capital,
        c.interes,
        c.capital + c.interes AS total,
        st.state_id,
        st.state
    FROM cuotas AS c
    JOIN (
        SELECT ccs.cuota_id,
            ccs.state_id,
            css.state
        FROM cuotas_state AS ccs
        JOIN cuota_states AS css ON ccs.state_id = css.id
    ) AS st ON c.id = st.cuota_id
)

CREATE VIEW prestamos_state AS (
    SELECT prestamo_id,
        MAX(state_id) AS state_id
    FROM (
        SELECT prestamo_id,
            CASE
                WHEN precedent_action = 2 THEN 5
                WHEN precedent_action = 3 THEN 1
                WHEN precedent_action = 4 THEN 0
                WHEN precedent_action = 5 THEN 2
                WHEN fecha_vto < CURRENT_DATE() THEN 4
                ELSE 3
            END AS state_id
        FROM (
            SELECT c.prestamo_id,
                c.fecha_vto,
                MAX(ca.action_id) AS precedent_action
            FROM cuotas AS c
            LEFT JOIN cuotas_actions AS ca ON c.id = ca.cuota_id
            GROUP BY c.id
        ) AS sq_1
    ) AS sq_2
    GROUP BY prestamo_id
)

CREATE VIEW prestamos_list AS (
    SELECT p.id,
        p.cod,
        cl.id AS cliente_id,
        cl.denominacion AS cliente_denominacion,
        st.state_id,
        st.state,
        mt.monto,
        st.cuotas,
        pd.periodicidad,
        p.tasa
    FROM prestamos AS p    
    JOIN clientes_list AS cl ON p.cliente_id = cl.id
    JOIN periodicidades AS pd ON p.periodicidad_id = pd.id
    JOIN (
        SELECT a.id, 
    	    SUM(m.debe) AS monto
        FROM asientos AS a
        JOIN minutas AS m ON a.id = m.asiento_id
        GROUP BY a.id
    ) AS mt ON p.asiento_id = mt.id
    JOIN (
        SELECT prestamo_id,
	    state_id,
            state,
            cuotas_cant AS cuotas
        FROM prestamos_state AS pps
        JOIN prestamo_states AS pss ON pps.state_id = pss.id
    ) AS st ON p.id = st.prestamo_id
)

CREATE VIEW prestamo_detail AS (
    SELECT p.id,
        p.cod,
        cl.denominacion AS cliente,
        sq.monto,
        sq.fecha_entrega,
        md.modalidad,
        pd.periodicidad,
        p.tasa
    FROM prestamos AS p    
    JOIN clientes_list AS cl ON p.cliente_id = cl.id
    JOIN (
        SELECT a.id,
            a.fecha AS fecha_entrega,
    	    SUM(m.debe) AS monto
        FROM asientos AS a
        JOIN minutas AS m ON a.id = m.asiento_id
        GROUP BY a.id
    ) AS sq ON p.asiento_id = sq.id
    JOIN periodicidades AS pd ON p.periodicidad_id = pd.id
    JOIN modalidades AS md ON p.modalidad_id = md.id
)

-- Dumping data

INSERT INTO user_roles (id, role) VALUES
(1, 'SysAdmin'),
(2, 'Director'),
(3, 'Encargado');

INSERT INTO users (name, pass, email, role_id) VALUES
('SysAdmin', '$2y$10$Tvp6DlbLdo1pvDnTvTP9zuUWPPmhE5r0S.8ZBPr5Vx9BBec3w5hnW', 'luciano@rumia.uno', 1);

INSERT INTO documento_types (id, type) VALUES
(1, 'DNI'),
(2, 'CUIT'),
(3, 'CUIL'),
(4, 'PAS');

INSERT INTO telefono_types (id, type) VALUES
(1, 'Móvil'),
(2, 'Casa'),
(3, 'Trabajo'),
(4, 'Otro');

INSERT INTO email_types (id, type) VALUES
(1, 'Personal'),
(2, 'Laboral'),
(3, 'Otro');

INSERT INTO domicilio_types (id, type) VALUES
(1, 'Real'),
(2, 'Legal/Fiscal'),
(3, 'Laboral'),
(4, 'Postal'),
(5, 'Otro');

INSERT INTO cuota_actions (id, action) VALUES
(1, 'Pago parcial'),
(2, 'Judicial'),
(3, 'Cancelación'),
(4, 'Refinanciación'),
(5, 'Incobrable');

INSERT INTO cuota_states (id, state) VALUES
(0, 'No vencida'),
(1, 'En mora'),
(2, 'Mora judicial'),
(3, 'Cancelada'),
(4, 'Refinanciada'),
(5, 'Incobrable');

INSERT INTO prestamo_states (id, state) VALUES
(1, 'Cancelado'),
(2, 'Incobrable'),
(3, 'Al día'),
(4, 'Con mora'),
(5, 'Mora judicial');

INSERT INTO modalidades (id, modalidad) VALUES
(1, 'Tasa s/monto'),
(2, 'Sist. Francés'),
(3, 'Sist. Alemán');

INSERT INTO periodicidades (id, periodicidad) VALUES
(1, 'Diaria'),
(2, 'Semanal'),
(3, 'Quincenal'),
(4, 'Mensual');

INSERT INTO cuentas (cod, denom, imputable, stock) VALUES
('100000', 'ACTIVO', 0, 0),
('110000', 'ACTIVO CORRIENTE', 0, 0),
('111000', 'DISPONIBILIDADES', 0, 0),
('111100', 'CAJAS', 0, 0),
('111101', 'Principal ARS', 1, 0),
('111102', 'Principal USD', 1, 1),
('111200', 'BANCOS', 0, 0),
('111300', 'OTRAS ENTIDADES FINANCIERAS', 0, 0),
('112000', 'CRÉDITOS DE LA ACTIVIDAD', 0, 0),
('112100', 'PRÉSTAMOS', 0, 0),
('112101', 'Prestamos ARS', 1, 0),
('112102', 'Prestamos USD', 1, 1),
('113100', 'CRÉDITOS FISCALES', 0, 0),
('113200', 'CRÉDITOS LABORALES', 0, 0),
('113201', 'Anticipo haberes', 1, 0),
('113300', 'CUENTAS PARTICULARES', 0, 0),
('120000', 'ACTIVO NO CORRIENTE', 0, 0),
('200000', 'PASIVO', 0, 0),
('210000', 'ACREEDORES', 0, 0),
('300000', 'PATRIMONIO NETO', 0, 0),
('310000', 'CAPITAL SOCIAL', 0, 0),
('320000', 'RESERVAS', 0, 0),
('330000', 'RESULTADOS NO ASIGNADOS', 0, 0),
('400000', 'RESULTADOS', 0, 0),
('410000', 'INGRESOS', 0, 1),
('411000', 'INTERESES POR PRESTAMOS', 0, 0),
('411001', 'Intereses Prestamos ARS', 1, 0),
('411002', 'Intereses Prestamos USD', 1, 1),
('420000', 'GASTOS', 0, 0),
('421000', 'GASTOS DE LA ACTIVIDAD', 0, 0),
('421001', 'Préstamos incobrables', 1, 0),
('422000', 'GASTOS LABORALES', 0, 0),
('422001', 'Haberes', 1, 0),
('423000', 'GASTOS FISCALES', 0, 0),
('423001', 'Impuestos', 1, 0),
('424001', 'Alquileres', 1, 0),
('424002', 'Servicios', 1, 0);