1. Authenticate on your Supabase account.
2. Create a new database.
3. Create a new table using the SQL editor passing the SQL to create the table. Example:
```sql
CREATE TABLE imoveis (
    id INT PRIMARY KEY,
    tipo_imovel VARCHAR(50),
    finalidade VARCHAR(20),
    preco DECIMAL(12, 2),
    cidade VARCHAR(100),
    bairro VARCHAR(100),
    quartos INT,
    banheiros INT,
    vagas_garagem INT,
    area_util_m2 FLOAT,
    mobiliado BOOLEAN,
    data_cadastro DATE
);
```
4. Populate the new table with some data (if you need to perform some retrieves on the table).
```sql
INSERT INTO imoveis (
    id,
    tipo_imovel,
    finalidade,
    preco,
    cidade,
    bairro,
    quartos,
    banheiros,
    vagas_garagem,
    area_util_m2,
    mobiliado,
    data_cadastro
) VALUES
(1, 'Apartamento', 'Venda', 450000.00, 'São Paulo', 'Moema', 2, 2, 1, 70, TRUE, '2024-11-01'),
(2, 'Casa', 'Aluguel', 3500.00, 'Belo Horizonte', 'Savassi', 3, 2, 1, 90, FALSE, '2024-10-10'),
(3, 'Studio', 'Venda', 200000.00, 'Curitiba', 'Batel', 1, 1, 0, 35, TRUE, '2024-09-15'),
(4, 'Cobertura', 'Venda', 1500000.00, 'Rio de Janeiro', 'Barra da Tijuca', 4, 4, 2, 250, TRUE, '2024-10-20'),
(5, 'Terreno', 'Venda', 300000.00, 'Campinas', 'Jardim Chapadão', 0, 0, 0, 400, FALSE, '2024-07-25');
```
5. Create a new PostgresSQL node and inform credentials to connect to the database. The connection credentials are available at Teble Editor > Connect > Session pool section.
[alt text](image.png)
6. 
   