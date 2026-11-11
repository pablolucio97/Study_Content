

# Prompt Engineering concepts and tips

## Prompt Engineering
- Process of structuring text (prompt) so that it can be interpreted and understood by a generative AI model.  
- A well-structured prompt leads to better, more accurate results.  

## Definition of Prompt
- A prompt is natural language text describing the task the AI should perform.  
- The more specific and clear the prompt, the better the AI’s performance.  

## Known Limitations of LLMs
1. **Hallucinations**: LLMs may invent false information if prompts are not well-restricted.  
2. **Mathematical Errors**: They can fail at precise calculations unless external tools are used.  
3. **Context Window**: Limited number of tokens (cannot handle very large texts at once).  
4. **Prompt Injection (Prompt Hack)**: Malicious prompts may trick the AI into revealing hidden or restricted instructions.  

## Roles
- **User**: Provides the prompt and context for the assistant to work with.
- **Assistant**: Interprets the prompt provided by the user and generates responses based on its training and the given context.
- **System**: Defines the rules, constraints, and context within which the assistant operates.

Examples of Prompts with different roles

- **User**: "Summarize the following text in one paragraph."
- **Assistant**: As assistant, I will summarize the text provided by the user in one paragraph.
- **System**: "The assistant should always provide concise summaries and avoid adding personal opinions."

## Prompt parameters
**Temperature**: Controls the randomness of the AI's responses. A higher value (e.g., 0.8) makes the output more diverse, while a lower value (e.g., 0.2) makes it more focused and deterministic.
**Max tokens**: Limits the number of tokens in the AI's response, helping to control response length and manage context window usage.
**Top-p (nucleus sampling)**: Controls the diversity and response extension of the AI's responses by sampling from the top probability mass. A higher value (e.g., 0.9) allows the model to choose from more likely tokens, while a lower value restricts the model to fewer tokens and less extended outputs.

## Prompt techniques
**Zero-shot**: Is the technique of not providing any example to follow.
**Few-shot**: Is the technique of providing one or few examples to follow.
**Chain-of-thought**: This technique is used when you ask the LLM to provide the thinking at replying, explaining the reasoning behind its answer.
**Prompt chaining**: Is used when you ask LLM to break a big step into small pieces passing the order of execution of each step.

## The ideal prompt model
1. Define the person that the LLM should assume and the goal you want to achieve.
2. Provide examples for avoiding undesirable results, few shots.
3. Define the steps that the LLM should take, prompt chaining.
4. Provide used and expected outputs for the examples, so the LLM can understand the desired results.
5. Provide enums or predefined options for the LLM to choose from, reducing ambiguity and improving response accuracy always as possible.
6. Define critical constraints or rules that the LLM must follow while generating responses.
7. Provide prompt parameters such as temperature, max tokens, and top-p to control the behavior and output of the LLM.
8. Send your prompt using separators such as "---" or "###" to clearly distinguish different sections of the prompt.

## Prompt Engineering Tips
- Understanding and applying prompt engineering techniques helps reduce hallucinations, avoid misuses, and achieve better results when interacting with generative AI and LLMs.
- Always provide a clear and objective prompt, avoid passing a too large context window (too many files, large file or content to be processed at once).
- Sometimes AI works better when the prompt text is written using XML, Placeholders (ex: {{Name}}), or Markdown formatting.
- At working prompts, supply relevant examples for the IA, it helps a lot at sharping the final response.
- At building a chatbot, provide several examples of how the IA should behave.
- Avoid doing a too much complex task at once, prefer to break it into smaller tasks, it provides better responses.
- Always define the expected output and constraints clearly to guide the LLM towards generating accurate and relevant responses.
- Always define the critical constraints and rules that the LLM must follow to ensure the generated responses meet the desired requirements.

### Most common prompt response output formats
- **Plain text**: The response is provided as simple text without any special formatting.
- **Markdown**: The response uses Markdown syntax for headings, lists, check-list, tables, code blocks, and other formatting elements.
- **JSON**: The response is structured as a JSON object, making it easy to parse and use programmatically.
- **XML**: The response is structured as an XML document, suitable for systems that require XML input.
- **Simple list**: The response is provided as a plain list of items, without additional formatting.
- **Numbered list**: The response is provided as a numbered list of items, making it easy to reference each item individually.
- **Inherit list**: The response is provided as a list that inherits items.
- **Key-value pairs**: The response is provided as a list of key-value pairs, making it easy to associate specific information with corresponding labels.
- **Bullet points**: The response is provided as a list of bullet points, making it easy to read and understand.
- **Table**: The response is provided in a tabular format, suitable for presenting structured data clearly.
- **Code block**: The response is provided as a block of code, suitable for programming-related outputs.
- **Custom format**: The response follows a user-defined format, which can include specific placeholders, separators, emojis, or templates.

### Using conditional prompts

Conditional prompts allow you to guide the AI's response based on specific conditions or criteria. This technique is useful for creating dynamic and context-aware interactions and fine-tuning the output according to user needs.

Include a fallback or default response for cases where none of the specified conditions are met.

**Example:**

```
You are an AI assistant specialized in responding to nutritionist doubts.
Task: Respond to nutritionist doubts according to his expertise and the context provided.
Constraints:
- Use simple language suitable for beginners.
- Adjust temperature based on the user's preference for response creativity.
- Adjust top-p based on the user's preference for response diversity.
Conditional:
- If the user is beginner, provide explanations suitable for someone new to nutrition concepts. Temperature: 0.5. Top-p: 0.7.
- If the user is intermediary or experienced, provide explanations that assume a solid understanding of nutrition concepts. Temperature: 0.2. Top-p: 0.3.
Expected Output:
- A clear response with reasoning based on the user's experience level.
- A fallback response for cases where the user's experience level does not match any specified condition.
```

### Using multi step prompts

Multi-step prompts involve breaking down a complex task into smaller, sequential steps, guiding the AI through each stage of the reasoning process. This approach helps in obtaining more accurate and structured responses, especially for tasks that require logical reasoning or multi-step problem-solving.

**Example:**

```
You are an AI assistant specialized in providing step-by-step guidance for solving complex problems.
Task: Help the user solve a multi-step problem related to AI concepts.
Steps:
1. Identify the problem and its requirements.
2. Break down the problem into smaller, manageable steps.
3. Guide the user through each step sequentially.
Constraints:
- Use simple language suitable for beginners.
- Provide explanations for each step.
- Limit the response to 300 words.
Expected Output:
- A clear, step-by-step solution to the problem.
- Explanations for each step.
Conditional:
- If the user is beginner, provide detailed explanations for each step. Temperature: 0.5. Top-p: 0.7.
- If the user is intermediary or experienced, provide concise explanations assuming prior knowledge. Temperature: 0.2. Top-p: 0.3.
- Fallback: Provide a generic step-by-step solution suitable for any user level. Temperature: 0.4. Top-p: 0.5.
```

---

**Example of a strong prompt:**

```
You are an AI assistant specialized in providing concise and accurate explanations of AI concepts.
Task: Explain the concept of "Prompt Engineering" in a clear and structured manner.
Constraints:
- Use simple language suitable for beginners.
- Provide examples where applicable.
- Limit the response to 200 words.
Expected Output:
- A clear definition of Prompt Engineering.
- Key techniques and tips for effective prompt creation.
- Examples illustrating the concept.
Conditional:
- If the user is beginner, provide explanations suitable for someone new to AI concepts. Temperature: 0.5. Top-p: 0.7.
- If the user is intermediary or experienced, provide explanations that assume a solid understanding of AI concepts. Temperature: 0.2. Top-p: 0.3.
- Fallback: Provide a generic explanation suitable for any user level. Temperature: 0.4. Top-p: 0.5.
```

**Example of a weak prompt:**

```
Explain Prompt Engineering.
```

#ai #concepts

**Related:** [[introduction_to_ai]] | [[rag_system]] | [[chatbots]]
