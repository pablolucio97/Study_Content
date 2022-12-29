Algoritmo "Ler 250 notas e classificar o aluno segundo sua nota."
// Disciplina  :  [Linguagem e Lógica de Programação] 
// Descrição   : Ler 250 notas e classificar o aluno segundo sua nota.
// Autor(a)    : Pablo Lúcio Santana
// Data atual  : 09/11/2018
Var
// Seção de Declarações das variáveis 
NOTA1, NOTA2, NOTA3, NOTA4, MEDIA, QTDNOTAS : REAL

Inicio
// Seção de Comandos, procedimento, funções, operadores, etc... 
 ESCREVA ("QUANTAS NOTAS DESEJA LER?")
 LEIA (QTDNOTAS)
 ENQUANTO QTDNOTAS < 250 FACA
 ESCREVA("DIGITE A PRIMEIRA NOTA: ")
 LEIA(NOTA1)
 ESCREVA("DIGITE A SEGUNDA NOTA: ")
 LEIA(NOTA2)
 ESCREVA("DIGITE A TECEIRA NOTA: ")
 LEIA(NOTA3)
 ESCREVA("DIGITE A QUARTA NOTA: ")
 LEIA(NOTA4)
 MEDIA := (NOTA1 + NOTA2 + NOTA3 + NOTA4) / 4 ;



 SE MEDIA <= 4  ENTAO
    ESCREVA("A MEDIA DO ALUNO FOI: ", MEDIA)
    ESCREVAL (" - ALUNO REPROVADO ")
 FIMSE
 SE MEDIA <=  6.9 ENTAO
    ESCREVA("A MEDIA DO ALUNO FOI: ", MEDIA)
    ESCREVAL (" - ALUNO DE RECUPERAÇÃO ")
 FIMSE
 SE MEDIA >= 7 ENTAO
    ESCREVA("A MEDIA DO ALUNO FOI: ", MEDIA)
    ESCREVAL (" - ALUNO APROVADO ")
 FIMSE
 FIMENQUANTO
Fimalgoritmo