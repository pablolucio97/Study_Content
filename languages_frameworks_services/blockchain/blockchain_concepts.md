# Blockchain concepts

## Blockchain basic working

### Blockchain structure

Blockchain technology servers as a decentralized ledger (a kind of reason book) that records all transactions across a network of computers. This decentralization ensures that no single entity has control over the entire history of transactions, but each transaction is verified by consensus mechanisms among the participants in the network.

### The role of linkage of blocks within a blockchain

In blockchain technology, a block is a set of transactions records that the network agrees to add to the the blockchain database. Each block is linked to the previous block via a cryptographic hash, forming an unbreakable chain. The role of linkage is ensuring the integrity of the blockchain's transactions history.

---

## Consensus Mechanisms

### Types of consensus mechanisms
- **Proof of Work (PoW)**: Proof of work requires participants (miners) to solve complex methamatical puzzles in order to add a new block to the chain. Solving complex mathematical puzzles grants that malicious actors do not flood the network easily altering the block-chain or creating false puzzles. Used in networks like Bitcoin.
- **Proof of Stake (PoS)**: Proof of Stake allocates block validation opportunities based on the number of coins a validator stakes (the probability of a participant being chosen to validate a block of transactions depends on the number of coins the participant holds). It is more energy-efficient compared to PoW. PoS discourages centralization by allowing a broader base of participants (stakers) rather than concentrating power in the hands of those with advanced mining hardware.
- **Proof of History (PoH)**: Solana's unique approach that integrates time to enhance the speed of consensus without the need for extensive communication between nodes. Proof of History enhances the scalability and speed of blockchain networks by providing a built-in chronological framework based on cryptographic sequential timestamps that simplifies and accelerates the consensus process.

---

