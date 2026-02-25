# Chatbots

## Chatbot techniques

### Tokenization
What it is: Splits a sentence into smaller units like words, subwords, or symbols.
How it is used: It is the first preprocessing step before intent detection or model input.
In chatbots: Helps the bot parse user messages correctly for downstream NLP tasks.

### Stop Words Removal
What it is: Removes very common words (like "the", "is", "and") with low semantic value.
How it is used: Reduces noise and keeps only informative terms for analysis.
In chatbots: Improves keyword matching, intent classification, and search relevance.

### Topic Modelling
What it is: Discovers hidden themes in text collections without manual labeling.
How it is used: Groups messages by topics such as billing, delivery, or technical support.
In chatbots: Supports routing conversations to the right flow, FAQ, or support team.

### Sentiment Analysis
What it is: Detects emotional tone, usually positive, negative, or neutral.
How it is used: Scores user messages to estimate satisfaction, frustration, or urgency.
In chatbots: Enables empathetic replies, escalation rules, and service-quality monitoring.

### Named Entity Recognition
What it is: Identifies entities in text, such as names, dates, locations, products, or IDs.
How it is used: Extracts structured data from free-form user sentences.
In chatbots: Captures key details for booking, payments, CRM updates, and automation.

### Stemming & Lemmatization
What it is: Normalizes words to root/base form (e.g., "running" to "run").
How it is used: Treats related word variants as the same concept during analysis.
In chatbots: Improves retrieval, intent matching, and consistency across user phrasing.

### Text Summarization
What it is: Creates a shorter version of long text while preserving core meaning.
How it is used: Condenses chat histories, documents, or agent notes.
In chatbots: Produces quick conversation summaries for handoff and follow-up actions.

### Keyword Extraction
What it is: Finds the most important words or phrases in a message.
How it is used: Highlights user intent signals without reading full text manually.
In chatbots: Powers fast intent hints, tagging, and content recommendations.

### Term Frequency in NLP
What it is: Measures how often each term appears in text or a corpus.
How it is used: Weights words to identify relevance, often with TF or TF-IDF methods.
In chatbots: Supports ranking answers, indexing FAQs, and lightweight classifiers.

### Machine Translation
What it is: Automatically translates text from one language to another.
How it is used: Converts user input and bot output across multilingual environments.
In chatbots: Enables a single bot experience for global users with different languages.

### Word Embedding
What it is: Represents words as numeric vectors that capture semantic similarity.
How it is used: Places related words close together in vector space for ML models.
In chatbots: Improves intent detection, semantic search, and context-aware responses.


## Types of chatbots
- **Q&A** Are chatbots that return generic responses.
- **Transactional** Are chatbots that consult external APIs before providing a response. E.g: consult weather API, dollar API, and so on.

## Types of chatbot interaction
- **Menu-based** Users navigate fixed options (buttons/menus) to get answers.
  Best for FAQs and simple, predictable flows.
- **AI-based (NLP)** Understands user text to detect intent and key entities.
  Used for more natural conversations with controlled business logic.
- **Generative AI** Produces original responses using LLM context, not fixed scripts.
  Used for open-ended support, personalization, and complex user questions.

## General tips
- At mouting chatbots in any platform, always think that there are too many ways the user could express himself. Example: User want to order bread, so he considering Brazilian context, he could say "Quero 3 pães", "Me vê 3 pães franceses", "Quero 3 cacetinhos" and so on. Train the ChatbotAI with at least 10 examples to mean the same user input.
- The more complete an input phrase is mount, best for AI understand what to process (convert to vector).
- At working with chatbots that depends or can be influenced by legal organizations, prefer fixed-response flows over Generative AI because some responses must follow a legal patterns instead of free responses.
- Each chat response depends on the previous questions context. If its more generic, use generative AI, otherwise train the LLM with your data.
- 
