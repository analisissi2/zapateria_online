
--Vistas
Select*from Datos_usuario;
Select*from Municipios_disponibles;
Select*from Direccion_envio_producto;
Select*from Datos_administrados;

--Datos de usuario
Create or replace view Datos_usuario as SELECT `correo` as "email",`contrasena` as "Contraseña",`nombre` as "Nombre",`apellido` as "Apellido",`estado` as "Estado de usuario",rol.cargo as "Rol en sistema" FROM rol INNER JOIN usuario ON rol.id_rol = usuario.rol_id_rol;

--Municipios_disponibles
Create view Municipios_disponibles as SELECT id_departamento as "Id departamento", departamento as "Departamento",municipio as "Municipio", departamento_id_departamento as "Id Municipio" FROM `departamento`, municipio WHERE departamento.id_departamento=municipio.departamento_id_departamento;

--Direccion envio
Create or replace view Direccion_envio_producto as SELECT u.correo as "email", u.nombre as "Nombre", u.apellido as "Apellido", r.cargo as "Rol en sistema", dr.telefono as "Teléfono", dr.codigo_postal as "Código postal", dr.direccion as "Dirección", d.departamento as "Departamento" FROM usuario u INNER JOIN direccion_envio dr ON u.correo =dr.usuario_correo INNER JOIN rol r ON r.id_rol = dr.usuario_rol_id_rol INNER JOIN departamento d ON d.id_departamento = dr.departamento_id_departamento;

--Datos administradores
Create or replace view Datos_administrador as SELECT a.nombre as "Nombre",a.apellido as "Apellido",a.correo as "email",a.contraseña as "Contraseña",a.telefono as "Teléfono",a.cargo as "Rol en sistema",a.estado as "Estado de usuario",r.cargo as "Cargo en empresa",de.nombre_empresa as "Nombre empresa" FROM dato_empresa de INNER JOIN admin a ON de.id_dato = a.dato_empresa_id_dato INNER JOIN rol r ON r.id_rol = a.rol_id_rol;

--Costo de envio--
create or replace view costo_envio_producto as SELECT d.departamento as "Departamento de envío",ce.costo as "Costo en dólares" FROM costo_envio ce INNER JOIN departamento d ON ce.departamento_id_departamento = d.id_departamento;

select*from costo_envio_producto;

--Productos con descuento--
create or replace view productos_con_descuento as SELECT p.nombre as "Nombre de promoción", td.descripcion as "Descripción de descuento",  d.`porcentaje` as "Porcentaje de descuento" FROM descuento d INNER JOIN tipo_descuento td ON d.tipo_descuento_id_tipo_descuento = td.id_tipo_descuento INNER JOIN producto p ON d.`producto_id_producto` = p.id_producto;

select*from productos_con_descuento;

--Direccion facturacion producto--
create or replace view Direccion_facturacion_producto as SELECT df.nombre as "Nombre",df.apellido as "Apellido",df.telefono as "Teléfono",df.correo as "email", df.direccion as "Direccion",d.departamento as "Departamento",u.correo as "email de usuario registrado",r.cargo as "Rol en el sistema" FROM direccion_facturacion df INNER JOIN departamento d ON df.departamento_id_departamento = d.id_departamento INNER JOIN usuario u ON df.usuario_correo = u.correo INNER JOIN rol r ON df.usuario_rol_id_rol = r.id_rol;

select*from Direccion_facturacion_producto;

--Existencias producto--

create or replace view Existencias_producto as SELECT e.cantidad as "Cantidad",p.nombre as "Marca" FROM existencia e INNER JOIN producto p ON e.producto_id_producto=p.id_producto;

select*from Existencias_producto;

--Pagos--
create or replace view Pagos as SELECT f.usuario_correo as "Usuario",r.cargo as "Rol en el sistema", f.tipo_pago as "Forma de pago" FROM forma_pago f INNER JOIN rol r ON f.usuario_rol_id_rol = r.id_rol;

select*from Pagos;

--Sugerencias--
create or replace view Sugerencias as SELECT m.usuario_correo as "Usuario",r.cargo as "Rol en el sistema",m.mensajes as "Mensajes recibidos" FROM mensajeria m INNER JOIN rol r ON m.usuario_rol_id_rol = r.id_rol;

select*from Sugerencias;

--Colores--
create or replace view Colores_productos as SELECT `id_color` as "Id color", `descripcion` as "color",marca as "Marca", precio as "Precio" FROM `color`,producto,marca where color_id_color=id_color; 

select*from Colores_productos;

--Pedidos--
create or replace view pedidos as SELECT o.fecha as "Fecha de la orden",o.total as "Total en dólares" ,o.usuario_correo as "Usuario",r.cargo as "Rol en el sistema",c.costo as "Costo unitario" FROM orden o INNER JOIN rol r ON o.usuario_rol_id_rol = r.id_rol INNER JOIN costo_envio c ON o.costo_envio_id_costo =c.id_costo;


--Pagos paypal--
Create or replace view pagos_paypal as SELECT p.correo as "Usuario",p.monto as "Monto de pago en dólares",f.tipo_pago as "Tipo pago" FROM PAYPAL p INNER JOIN forma_pago f ON p.forma_pago_id_tipo_pago = f.id_tipo_pago;

select*from pagos_paypal;

--Productos registrados--
create or replace view productos_registrados as SELECT p.nombre as "Modelo",p.imagen as"Imagen",p.precio as "Precio unitario",p.descripción as "Descripción",po.empresa as "Proveedor",t.tamaño as "Talla",c.descripcion as "Color",ca.nombre as "Categoría",m.marca as "Marca" FROM producto p INNER JOIN proveedor po ON p.proveedor_id_proveedor =po.id_proveedor INNER JOIN talla t ON p.talla_id_talla = t.id_talla INNER JOIN color c ON p.color_id_color = c.id_color INNER JOIN categoria ca ON p.categoria_id_categoria =ca.id_categoria INNER JOIN marca m ON p.marca_id_marca = m.id_marca;

select*from productos_registrados;

--subcategorias productos--
create or replace view Subcategorias_productos as SELECT c.nombre as "Categoria", s.nombre as "Sub Categoria",s.descripcion as "Descripción" FROM subcategoria s INNER JOIN categoria c ON s.categoria_id_categoria = c.id_categoria;

select*from Subcategorias_productos;

--Pago tarjeta credito--
create or replace view Pago_tarjeta_credito as SELECT t.nombre_titular as "Nombre de titular", t.numero_tdc as "Numero de tarjeta de crédito",  t.fecha_expiracion as "Fecha de expiracion",t.CCV2 as "Código de seguridad" FROM tarjeta_credito t INNER JOIN forma_pago f ON t.forma_pago_id_tipo_pago = f.id_tipo_pago;

select*from Pago_tarjeta_credito;
-- Categorias de producto
Create or replace view categoria_productos as SELECT `nombre` as "Nombre",`descripcion` as "Descripción" FROM categoria;
select*from categoria_productos;



