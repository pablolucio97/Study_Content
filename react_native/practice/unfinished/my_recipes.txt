import React from 'react'
import {createStackNavigator} from '@react-navigation/stack'
import {NavigationContainer} from '@react-navigation/native'

import Home from './assets/screens_minhas_receitas/Home'
import Plates from './assets/screens_minhas_receitas/Plates'
import Saltys from './assets/screens_minhas_receitas/Saltys'
import Sweets from './assets/screens_minhas_receitas/Sweets'
import CheeseBread from './assets/screens_minhas_receitas/CheeseBread'
import ChocolateCake from './assets/screens_minhas_receitas/ChocolateCake'
import Cookies from './assets/screens_minhas_receitas/Cookies'
import FeijaoTropeiro from './assets/screens_minhas_receitas/FeijaoTropeiro'
import Feijoada from './assets/screens_minhas_receitas/Feijoada'
import Fricasse from './assets/screens_minhas_receitas/Fricasse'
import IceCream from './assets/screens_minhas_receitas/IceCream'
import KitchenPie from './assets/screens_minhas_receitas/KitchenPie'
import PortuguesePastel from './assets/screens_minhas_receitas/PortuguesePastel'
import Sanduiche from './assets/screens_minhas_receitas/Sanduiche'
import ToastKitchen from './assets/screens_minhas_receitas/ToastKitchen'
import TraditionalPie from './assets/screens_minhas_receitas/TraditionalPie'
import Write from './assets/screens_minhas_receitas/Write'
import WritedRecipes from './assets/screens_minhas_receitas/WritedRecipes'

const Stack = createStackNavigator()

const App = () => {


  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName='Home'>
        <Stack.Screen  name='Home' component={Home} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Pratos' component={Plates} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Sobremesas' component={Sweets} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Lanches' component={Saltys} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Bolo de chocolate' component={ChocolateCake} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Sorvete caseiro' component={IceCream} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Cookies' component={Cookies} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Torta tradicional' component={TraditionalPie} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Fricassê de frango' component={Fricasse} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Frango assado' component={ToastKitchen} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Feijoada' component={Feijoada} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Feijão tropeiro' component={FeijaoTropeiro} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Sanduíche caseiro' component={Sanduiche} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Pão de queijo' component={CheeseBread} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Pastel português' component={PortuguesePastel} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Torta de frango' component={KitchenPie} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
          <Stack.Screen  name='Escrever receita' component={Write} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
            <Stack.Screen  name='Visualizar receita' component={WritedRecipes} options={{
          headerStyle:{
            backgroundColor: '#62ff'
          },
          headerTintColor: '#FFF',
          headerTitleAlign: 'center',
          headerTitleStyle: {
            fontSize: 18
          }
        }} />
      </Stack.Navigator>
    </NavigationContainer>
  )
}

export default App
