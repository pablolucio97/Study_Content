
# AMAZON WEB SERVICES

## OVERVIEW

AWS (Amazon Web Services) is a comprehensive cloud computing platform offering services including compute, storage, database, networking, analytics, machine learning, and more.

---

## REGIONS & AVAILABILITY ZONES

**Region**: A geographical area containing multiple isolated locations known as Availability Zones (AZs).  
**AZs**: Independent data centers within a region.

---

## APPLICATION ARCHITECTURES

- **Monolithic**: Tightly coupled components.
- **Microservices**: Loosely coupled, independently deployable services.

---

## CLOUD COMPUTING ADVANTAGES

- No need for managing physical infrastructure.
- Pay-as-you-go pricing model.
- Auto-scaling and fault tolerance.

---

## DEPLOYMENT MODELS

- **Cloud**: All infrastructure on the cloud.
- **Hybrid**: Combination of cloud and on-premises.
- **On-premises**: Local data centers with possible cloud integrations.

---

## SERVICE MODELS

- **IaaS**: Infrastructure (e.g., EC2).
- **PaaS**: Platform (e.g., AWS Elastic Beanstalk).
- **SaaS**: Software as a Service (e.g., Amazon WorkMail).

---

## COMPUTE SERVICES

### Amazon EC2
Virtual servers in the cloud with scalability and flexibility.
```ts
// Example: Launch an EC2 instance
aws ec2 run-instances --image-id ami-xyz --count 1 --instance-type t2.micro
```

### EC2 Auto Scaling
Automatically adds or removes instances based on demand.

### AWS Lambda
Run code without managing servers (event-driven).

---

## CONTAINER SERVICES

- **Amazon ECS**: Container orchestration.
- **Amazon EKS**: Kubernetes on AWS.
- **AWS Fargate**: Serverless containers.

---

## NETWORKING

### Amazon VPC
Create isolated networks.
- Public/private subnets
- Internet Gateway
- NAT Gateway

### Amazon Route 53
DNS service to route traffic globally.

---

## STORAGE

### Amazon S3
Object storage for files up to 5TB.
- Standard
- Infrequent Access
- Glacier & Glacier Deep Archive

### Amazon EBS
Block storage for EC2.

### Amazon EFS
Elastic file storage for use with EC2.

---

## DATABASES

- **Amazon Aurora**: MySQL/PostgreSQL-compatible
- **Amazon RDS**: Managed relational DB
- **DynamoDB**: NoSQL, key-value
- **ElastiCache**: In-memory cache
- **DMS**: Database Migration Service

---

## SECURITY

- **IAM**: Identity and Access Management
- **KMS**: Key Management Service
- **AWS WAF**: Web Application Firewall
- **AWS Shield**: DDoS protection

---

## MONITORING

- **CloudWatch**: Logs and metrics
- **CloudTrail**: API activity tracking
- **Trusted Advisor**: Best practice checks

---

## PRICING & BILLING

- **Free Tier**
- **12-Month Free**
- **Pay-as-you-go**
- **Savings Plans**
- **Cost Explorer** & **Budgets**

---

## MIGRATION & INNOVATION

- **CAF (Cloud Adoption Framework)**
- **Snow Family**: Physical migration devices
- **Machine Learning**: Amazon SageMaker
- **AI Services**: Transcribe, Lex

---

## SUPPORT PLANS

- Basic
- Developer
- Business
- Enterprise

---

## WELL-ARCHITECTED FRAMEWORK

1. Operational Excellence
2. Security
3. Reliability
4. Performance Efficiency
5. Cost Optimization

---

## GENERAL TIPS

- Use multiple AZs for high availability.
- Test latency via www.cloudping.info.
- Use CloudFront and caching for performance.

---
