paralelismo

concorrencia

alocação de memoria

self healing

escalabilidade

tipos de arquiteturas: arquitetura de software, arquitetura de soluções, arquitetura tecnológca, arquitetura corporativa, requisitos arquiteturais (RAs),  arquitetura hexagonal e etc
clean architeture

solid

domain driven design e modelagem de dados

como criar mecanismos para evitar vazamento de dados

caching vs edge computing

proxy e proxy reverso 

rate limit

api gateway

## API Gateway

An API gateway is a management tool used to unify a single point of communication between different backend APIs and clients. The gateway need to have security layers because it is the entry point from external world. Its main functionalities are:
- Requests callings control (rate limiting)
- Authentication
- Logs control
- Standard metrics (used to know which status code are being more returned and so on)
- API's management (through routing)
  

service mesh

health check

ver curso Fundamentos da arquitetura de software


curl command


## General tips

At building an API Gateway, you must have at least two instances running your gateway, because if an instance dies, the another one is alive.







