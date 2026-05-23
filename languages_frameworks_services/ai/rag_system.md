

# RAG System

A RAG (Retrieval-Augmented Generation) is a technique where a language model retrieve an external data before generating an answer instead relying only on its training data. The RAG searches a knowledge source (like a database or document collection) to produce more accurate, grounded, and updated responses. The RAG techinique acts improving the response retrievel to external provided data.

RAG combines **retrieval** (fetching external data) and **generation** (creating responses) to build smarter and more factual AI systems. For example, it can use a vector database feed with a business data to reply based on this business data.

## Key Components in RAG

1. **Embeding model**  
   - Is a model that user external resource documents (text, PDFs, databases) to be splited into small chunks, chunking (like paragraphs in a text), and transformed into embeddings (numerical vectors).  
   - These embeddings are stored in a vectorial database (PineCone, QDrant, Vespa, Chroma and so on) with metadata and links to the original content.

2. **Retrieval**  
   - When a user asks something, the query is converted into an embedding.  
   - The system retrieves the most similar embeddings (relevant texts) from the vector database.

3. **Augmentation / Prompt Construction**  
   - The retrieved data is added to the model’s prompt or context window.  
   - This gives the model the extra knowledge it needs to answer more precisely.

4. **Generation**  
   - The LLM processes the combined prompt (user query + retrieved context).  
   - The final answer is more factual, context-aware, and source-grounded.

5. **Source Attribution (optional)**  
   - The model or system can return the sources of the retrieved information, increasing transparency and reliability.

## RAG Architecture
The RAG archiecture is basicaly based on the flow below:
1. A souce data (database, document, site, audio, and so on) is converted into chunks and stored to a vectorial database connected to a LLM.
2. User do a question.
3. The LLM embeds the user question transforming it into a numeric vector, compares this vector with similar vectors present on the vectorial database, mounts a new numeric vector containing the user response, generates an embeding and reply user.

## Deploying RAG systems to production to be consumed as API

1. Create your RAG through Jupyter Notebook using .ipynb files.
2. Activate the venv running the command `source /your_machine_venv_path/.venv/bin/activate`
3. Navigate to the file folder, and convert your .ipynb files to .py files using the command `python3 -m jupyter nbconvert --to python --no-prompt my_file.ipynb `
4. Adjust the generated .py files code to work only with functions, generaly a single .py file is generated, so at end of this file, create a funcion to call AWS Lambda to execute your script in the cloud. If there is some environemnt variable, read it from os.envinron, do not pass it hardcoded.
5. Create a .installers.py file to tell Docker wich libraries your project depends on. Pay attention on replacing all "_" for "-" because the environment differences.
6. Create .Dockerfile containing the instructions to generate your application image.
7. Build the Docker image for linux/x86_64 platform using the command `docker build --platform linux/x86_64 -t myimage .`.
8. Install the AWS CLI, log into your AWS account, access the IAM resource, select your user, click on `Security credentials`, click on `Crete access key`, generate a new new access key for command line.
9. Run the command `aws configure`, provide the access key, and secret key generated from step 9, provide a ragion name ex `us-east-1` to configure the AWS CLI locally.
10. Create the ECR on AWS accessing the resource ` ECR - Elastic Container Register`, create a new repository providing a name for it. The repository will be created with no images.
11. Click on `View push commands` to see the Docker image push commands instructions. Pay attention to build the image, tag it, and push it using the same image name.
12. Push your image to AWS ECR (AWS Elastic Container).
13. Search for Lambada on AWS, create a new Lambda function selecting the the uploaded image. Pay attention to use the same architecture used to build the image (x86_64), define the execution time to 10 minutes, and add the environment variables need to execute the Lambda function.
14. Test the lambda function calling it passing the same param as defined on Python code on event.get("yourEvent").
15. After tested the lambda function, adjust the lambda function in the Python code to read events from body instead of event.get. 
16. Test calling the Lambda function from the AWS provided endpoint using Curl or a REST client.


## General tips 
- At building RAG's systems manually, defined chunk overlap of 20, and chunk size of 4000 tokens for paragraphs and 1500 to FAQ's.
- Chunk sizes, chunk overlay and top keys must vary according the kind of document are you analysing. How shorter is your chunk size, how many top keys (relevant chunks) you will need.
- Pay attention to not provide documents that contains information that is not correct in real life beucase the RAG system will considerate the document content over real life.
- Computers in general always works better with numbers because it's more easy to convert in bits. So the embeding models transform the piece of data in a bunch of numeric vetctors and send it to vectorial database.
- At building Rag Systems, configure the chunk_sizes, chunk_overlaps, and top_keys according to the content you are working on. Pay attenttion to not use chunk_sizes too small, and it getting in the way to highlight top_keys. The more small are chunk_sizes, more top_keys you will need to consider as relevant for your answer. Test these values according the document you are working.
- Always work with Parent RAG architecture instead of Base RAG splitting the chunks in large chunks (parent chunks) and then splitting them into smaller chunks (children chunks) to finally retrieve it to solve the precision/context correlation problem at building RAGs.
- At working with Parent RAG, defined at least 10 known chunks to create a solid ranking for wich response is the more appropriated.

---

#ai #database #concepts

**Related:** [[introduction_to_ai]] | [[prompt_engineering]] | [[chatbots]]
