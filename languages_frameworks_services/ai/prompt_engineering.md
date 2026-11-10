

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

## Prompt Engineering Tips
- Understanding and applying prompt engineering techniques helps reduce hallucinations, avoid misuses, and achieve better results when interacting with generative AI and LLMs.
- Always provide a clear and objective prompt, avoid passing a too large context window (too many files, large file or content to be processed at once).
- Sometimes AI works better when the prompt text is written using XML, Placeholders (ex: {{Name}}), or Markdown formatting.
- At working prompts, supply relevant examples for the IA, it helps a lot at sharping the final response.
- At building a chatbot, provide several examples of how the IA should behave.
- Avoid doing a too much complex task at once, prefer to break it into smaller tasks, it provides better responses.
- Always define the expected output and constraints clearly to guide the LLM towards generating accurate and relevant responses.
- Always define the critical constraints and rules that the LLM must follow to ensure the generated responses meet the desired requirements.

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
```

**Example of a weak prompt:**

```
Explain Prompt Engineering.
```

#ai #concepts

**Related:** [[introduction_to_ai]] | [[rag_system]] | [[chatbots]]
