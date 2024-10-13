# CLEAN ARCHITECTURE ON NODEJS APPLICATIONS

In Clean Architecture, the **useCases** layer must not depend on the **controllers** layer.

Your application adopts the Clean Architecture concept when it’s possible to change the entire **useCases** and **entities** layers without affecting the **controllers** layer.

## Clean Architecture Flow

- **Development Flow**: 
  `Database => Repository => Entities => Use Cases => Controllers => Client`

- **Client Request Flow**: 
  `Client => Controllers => Use Case => Entities => Repository => Database`

### Concepts

#### Database
The database itself.

---

#### Repository
A contract containing the methods of your system to handle data in the database, which will be available for each use case according to the method the use case needs.

---

#### Entities
The representation of your database tables in the code.

---

#### Use Cases
Responsible for communicating with your entities and performing each method of your system according to your business rules. Use cases need a repository containing all methods of your system so that each use case knows which method to implement.

---

#### Controllers
Responsible for protecting the system from client requests, ensuring that the request follows the business rules.

---

#### Mappers
In Clean Architecture, it’s common to have a single Entity with different representations. For example, a representation of the ORM database object typing (external layer) and another for the entity class typing (on the domain layer). Mappers are responsible for converting data from one layer to another.

**Example: Converting a Prisma Question to an Entity Question**

```ts
import { UniqueEntityID } from '@/core/entities/unique-entity-id'
import { Question } from '@/domain/forum/enterprise/entities/question'
import { Slug } from '@/domain/forum/enterprise/entities/value-objects/slug'
import { Question as PrismaQuestion } from '@prisma/client'

export class PrismaQuestionMapper {
  
  // Convert the Prisma object into ORM database object
  static toDomain(raw: PrismaQuestion): Question {
    return Question.create(
      {
        title: raw.title,
        content: raw.content,
        authorId: new UniqueEntityID(raw.authorId),
        bestAnswerId: undefined,
        slug: Slug.create(raw.slug),
        createdAt: raw.createdAt,
        updatedAt: raw.updatedAt,
      },
      new UniqueEntityID(raw.id),
    )
  }

  // Convert the ORM database object into a Prisma object
  static toPrisma(question: Question): Prisma.QuestionUncheckedCreateInput {
    return {
      id: question.id.toString(),
      authorId: question.authorId.toString(),
      bestAnswerId: question.bestAnswerId?.toString(),
      title: question.title,
      content: question.content,
      slug: question.slug.value,
      createdAt: question.createdAt,
      updatedAt: question.updatedAt,
    }
  }
}
```

  **Example: How to implement a repository**
  
```ts
@Injectable()
export class PrismaQuestionsRepository implements QuestionsRepository {
  constructor(private prisma: PrismaService) {}
  
  async findById(id: string): Promise<Question | null> {
    const question = await this.prisma.question.findUnique({
      where: {
        id,
      },
    });

    if (!question) {
      return null;
    }

    return PrismaQuestionMapper.toDomain(question);
  }
}
```