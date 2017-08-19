
--Vistas
--Datos de usuario
Create or replace view Datos_usuario as SELECT `correo` as "email",`contrasena` as "Contraseña",`nombre` as "Nombre",`apellido` as "Apellido",`estado` as "Estado de usuario",rol.cargo as "Rol en sistema" FROM rol INNER JOIN usuario ON rol.id_rol = usuario.rol_id_rol;

--Municipios_disponibles
Create view Municipios_disponibles as SELECT id_departamento as "Id departamento", departamento as "Departamento",municipio as "Municipio", departamento_id_departamento as "Id Municipio" FROM `departamento`, municipio WHERE departamento.id_departamento=municipio.departamento_id_departamento;

--Direccion envio
Create or replace view Direccion_envio_producto as SELECT u.correo as "email", u.nombre as "Nombre", u.apellido as "Apellido", r.cargo as "Rol en sistema", dr.telefono as "Teléfono", dr.codigo_postal as "Código postal", dr.direccion as "Dirección", d.departamento as "Departamento" FROM usuario u INNER JOIN direccion_envio dr ON u.correo =dr.usuario_correo INNER JOIN rol r ON r.id_rol = dr.usuario_rol_id_rol INNER JOIN departamento d ON d.id_departamento = dr.departamento_id_departamento;

--Datos administradores
Create or replace view Datos_administrados as SELECT a.nombre as "Nombre",a.apellido as "Apellido",a.correo as "email",a.contraseña as "Contraseña",a.telefono as "Teléfono",a.cargo as "Rol en sistema",a.estado as "Estado de usuario",r.cargo as "Cargo en empresa",de.nombre_empresa as "Nombre empresa" FROM dato_empresa de INNER JOIN admin a ON de.id_dato = a.dato_empresa_id_dato INNER JOIN rol r ON r.id_rol = a.rol_id_rol;

