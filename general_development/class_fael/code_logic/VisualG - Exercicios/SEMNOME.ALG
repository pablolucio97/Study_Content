Algoritmo "semnome"
// Disciplina  :  [Linguagem e Lógica de Programação] 
// Professor   : Antonio Carlos Nicolodi 
// Descrição   : Aqui você descreve o que o programa faz! (função)
// Autor(a)    : Nome do(a) aluno(a)
// Data atual  : 09/11/2018
Var
// Seção de Declarações das variáveis 
   X, Y, I : vetor[1..10] de inteiro
   U: vetor[1..20] de inteiro
   j, k, l, cont_I, cont_U: inteiro
   ja_consta: caracter
Inicio
// Seção de Comandos, procedimento, funções, operadores, etc... 
 para j de 1 ate 10 faca
      escreva("Informe X[", j, "]: ")
      leia(X[j])
   fimpara
   para j de 1 ate 10 faca
      escreva("Informe Y[", j, "]: ")
      leia(Y[j])
   fimpara
   // União
   cont_U <- 0
   para j de 1 ate 10 faca
      ja_consta <- "N"
      para k de 1 ate cont_U faca
         se (X[j] = U[k]) entao
            ja_consta <- "S"
         fimse
      fimpara
      se (ja_consta = "N") entao
         cont_U <- cont_U + 1
         U[cont_U] <- X[j]
      fimse
   fimpara
   para j de 1 ate 10 faca
      ja_consta <- "N"
      para k de 1 ate cont_U faca
         se (Y[j] = U[k]) entao
            ja_consta <- "S"
         fimse
      fimpara
      se (ja_consta = "N") entao
         cont_U <- cont_U + 1
         U[cont_U] <- Y[j]
      fimse
   fimpara
   escreval("União: ", cont_U, " elementos")
   para l de 1 ate cont_U faca
      escreva(" ", U[l])
   fimpara
   escreval("")
   // Intersecção
   cont_I <- 0
   para j de 1 ate 10 faca
      para k de 1 ate 10 faca
         se (X[j] = Y[k]) entao
            ja_consta <- "N"
            para l de 1 ate cont_I faca
               se (X[j] = I[l]) entao
                  ja_consta <- "S"
               fimse
            fimpara
            se (ja_consta = "N") entao
               cont_I <- cont_I + 1
               I[cont_I] <- X[j]
            fimse
         fimse
      fimpara
   fimpara
   escreval("Intersecção: ", cont_I, " elementos")
   para i de 1 ate cont_I faca
      escreva(" ", I[i])
   fimpara
   escreval("")
fimalgoritmo
