
## Prompt Engineering concepts and tips

### Prompt Engineering
- Process of structuring text (prompt) so that it can be interpreted and understood by a generative AI model.  
- A well-structured prompt leads to better, more accurate results.  

### Definition of Prompt
- A prompt is natural language text describing the task the AI should perform.  
- The more specific and clear the prompt, the better the AI’s performance.  

### Known Limitations of LLMs
1. **Hallucinations**: LLMs may invent false information if prompts are not well-restricted.  
2. **Mathematical Errors**: They can fail at precise calculations unless external tools are used.  
3. **Context Window**: Limited number of tokens (cannot handle very large texts at once).  
4. **Prompt Injection (Prompt Hack)**: Malicious prompts may trick the AI into revealing hidden or restricted instructions.  

### Prompt techniques
**Zero-shot**: Is the technique of not providing any example to follow.
**Few-shot**: Is the technique of providing one or few examples to follow.
**Chain-of-thought**: This technique is used when you ask the LLM to provide the thinking at replying.
**Prompt chaining**: Is used when you ask LLM to break a big step into small pieces passing the order of execution of each step.

### The ideal prompt model
1. Define the person that the LLM should assume and the goal you want to achieve.
2. Provide examples for avoiding undesirable results, few shots.
3. Define the steps that the LLM should take, prompt chaining.

### Prompt Engineering Tips
- Understanding and applying prompt engineering techniques helps reduce hallucinations, avoid misuses, and achieve better results when interacting with generative AI and LLMs.
- Always provide a clear and objective prompt, avoid passing a too large context window (too many files, large file or content to be processed at once).
- Sometimes AI works better when the prompt text is written using XML, Placeholders (ex: {{Name}}), or Markdown formatting.
- At working prompts, supply relevant examples for the IA, it helps a lot at sharping the final response.
- At building a chatbot, provide several examples of how the IA should behave.
- Avoid doing a too much complex task at once, prefer to break it into smaller tasks, it provides better responses.