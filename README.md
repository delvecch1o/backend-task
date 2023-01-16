# backend-task

## Data Models

### Profile
Um perfil pode ser um `client` ou um `contractor`.
clientes criam contratos com contratantes. contratante faz trabalhos para clientes e é pago.
Cada perfil tem uma propriedade de equilíbrio.

### Contract
Um contrato entre um client e um contractor.
Os contratos têm 3 status, `new`, `in_progress`, `terminated`. os contratos são considerados ativos somente quando em estado `in_progress`
Os contratos agrupam trabalhos dentro deles.

### Job
o contratante é pago pelos trabalhos dos clientes sob um determinado contrato.

## APIs To Implement 

1. ***GET*** `/contracts/:id` -  deve retornar o contrato somente se pertencer ao perfil que está chamando.


1. ***GET*** `/contracts` - Retorna uma lista de contratos pertencentes a um usuário (client ou contractor), a lista deve conter apenas contratos não rescindidos.


1. ***GET*** `/jobs/unpaid` - Obtenha todos os trabalhos não pagos para um usuário (****** um client ou contractor), apenas para ***contratos ativos***.


1. ***POST*** `/jobs/:job_id/pay` - Pagar por um trabalho, um cliente só pode pagar se seu saldo >= o valor a pagar. O valor deve ser transferido do saldo do cliente para o saldo do contratante.

1. ***POST*** `/balances/deposit/:userId` - Deposita dinheiro no saldo de um cliente, um cliente não pode depositar mais de 25% do total de trabalhos a pagar. (no momento do depósito)

1. ***GET*** `/admin/best-profession?start=<data>&end=<data>` - Retorna a profissão que rendeu mais dinheiro (soma dos empregos pagos) para qualquer contractor que trabalhou no intervalo de tempo de consulta.

1. ***GET*** `/admin/best-clients?start=<data>&end=<data>&limit=<inteiro>` - retorna os clientes que mais pagaram por trabalhos no período de consulta. O parâmetro de consulta limit deve ser aplicado, o limite padrão é 2.


```
 [
    {
        "id": 1,
        "fullName": "Reece Moyer",
        "paid" : 100.3
    },
    {
        "id": 200,
        "fullName": "Debora Martin",
        "paid" : 99
    },
    {
        "id": 22,
        "fullName": "Debora Martin",
        "paid" : 21
    }
]
```












