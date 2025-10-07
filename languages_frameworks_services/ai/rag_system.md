# RAG System

A RAG (Retrieval-Augmented Generation) is a technique where a language model retrieve an external data before generating an answer instead relying only on its training data. The RAG searches a knowledge source (like a database or document collection) to produce more accurate, grounded, and updated responses.

RAG combines **retrieval** (fetching external data) and **generation** (creating responses) to build smarter and more factual AI systems. For example, it can use a vector database feed with a business data to reply based on this business data.

## Key Components in RAG

1. **Indexing / Embedding / Storage**  
   - Source documents (text, PDFs, databases) are split into small chunks and transformed into embeddings (numerical vectors).  
   - These embeddings are stored in a vector database with metadata and links to the original content.

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


