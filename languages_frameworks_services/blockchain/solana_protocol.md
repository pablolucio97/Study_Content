# Solana Protocol

## How Solana Protocol works

## Introduction
Solana is a high-performance blockchain known for its exceptional speed and efficiency. It operates on a low-latency network that supports thousands of transactions per second with a block time of just 400 milliseconds. The platform is designed to maximize hardware efficiency, ensuring that applications built on Solana can scale effectively without the complications of bridging or liquidity fragmentation.

### Transaction Lifecycle resume
1. Users submit transactions to the lead block producer, referred to as the leader. 
2. The leader compiles these into a block, executes them, and updates the blockchain's state. 
3. This block is then disseminated across the network where other validators execute and confirm the transactions.
4. Transactions are finalized and irreversibly added to the blockchain

### Six Stages
The operation of Solana can be conceptualized through six key stages, which provide a framework to understand the relationships and functions within the network:
1. **Leadership**: The process of transaction compilation and block creation.
2. **Consensus**: Validators work to agree on the validity of blocks.
3. **Execution**: Transactions within a block are executed and the state is updated.
4. **Propagation**: Blocks are propagated to all nodes in the network.
5. **Finalization**: Transactions are finalized and irreversibly added to the blockchain.
6. **Optimization**: Ongoing improvements and protocol upgrades.

---


## Solana User Interaction Flow in resume

### Concepts 

**Wallet**
  Wallets generate cryptographic keypairs (public and private keys). The public key serves as the account identifier, and is known by all participants in the network. A user’s account on Solana can be considered a data structure that holds information and state related to their interactions with the Solana blockchain.

**User Account**
   - The public key uniquely identifies the user's account on the Solana blockchain, akin to a filename in a filesystem.
   - The private key, used for signing transactions, acts as the password to this account. Keypairs may also be derived from mnemonic seed phrases for easier management. Private keys can also be derived from 12 or 24 words long. This format is often used by wallets for easier backup and recovery.

**Transaction Components**
   - **Account Addresses:** Lists all accounts involved in the transaction.
   - **Header:** Specifies which accounts must sign.
   - **Recent Blockhash:** Used to prevent duplicate transactions, expires after about 1 minute.
   - **Instructions:** Define the operations to be performed (e.g., transfers, account modifications).

## Flow

### 1. **Wallet Connection**
   - The user connects their wallet to the application.
   - The application can read the user’s public key while the private key remains encrypted and secure.

### 2. **Transaction Preparation**
   - The application builds the transaction parameters based on user inputs.
   - Scenarios include swapping tokens, where the user specifies the amounts and types of tokens to exchange and the acceptable slippage.

### 3. **Signing Transactions**
   - The transaction details are sent to the user's wallet for signing.
   - The user reviews and approves the transaction via a popup, which might include a transaction simulation.

### 4. **Submitting Transactions**
   - Once signed, the transaction, including the user’s signature, is returned to the application.
   - The application then forwards the signed transaction to an RPC provider.

### 5. **RPC Providers**
   - RPC providers act as intermediaries between the application and the blockchain validators.
   - They manage the submission of signed transactions to the blockchain and retrieval of on-chain data via JSON-RPC or WebSocket endpoints.



### General considerations

- Solana is a little bit more complex protocol compared to another cryptocurrencies protocols.
- Sending a transaction is the only way to mutate state on Solana.
- Keypairs are the 64-byte combinations of public (first half) and private (second half) keys.
- Solana uses the Ed25519 digital signature algorithm for cryptographic needs, ensuring small key sizes and fast computations.

### References
[Solana Introduction Guide](https://report.helius.dev/)
[Solana RPC API](https://solana.com/docs/rpc)