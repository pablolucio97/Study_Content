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


## General tips 
- At building RAG's systems manually, defined chunk overlap of 20, and chunk size of 4000 tokens for paragraphs and 1500 to FAQ's.
- Chunk sizes, chunk overlay and top keys must vary according the kind of document are you analysing. How shorter is your chunk size, how many top keys (relevant chunks) you will need.
- Pay attention to not provide documents that contains information that is not correct in real life beucase the RAG system will considerate the document content over real life. 