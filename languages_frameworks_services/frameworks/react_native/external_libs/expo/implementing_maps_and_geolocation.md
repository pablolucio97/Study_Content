# Implementing Maps with current user location

## Implementing Geolocation
1. Install the expo-location library running `npx expo install expo-location`
2. Add the expo plugin to your app.json file. Ex:
   ```json
       "plugins": [
      [
        "expo-location",
        {
          "locationAlwaysAndWhenInUsePermission": "Allow $(PRODUCT_NAME) to use your location."
        }
      ]
    ]
   ```
3. Create a hook to request for user location, get the user coords, then creates a function to get user address based on his location. Example:
```typescript
import {
    LocationAccuracy,
  LocationSubscription,
  useForegroundPermissions,
  watchPositionAsync,
} from "expo-location";
import { LocationObjectCoords, reverseGeocodeAsync } from "expo-location";
import { CarSimple } from "phosphor-react-native";
import { useEffect, useRef, useState } from "react";
import { Alert, ScrollView, TextInput } from "react-native";
import { KeyboardAwareScrollView } from "react-native-keyboard-aware-scroll-view";
import { Button } from "../../components/Button";
import { Header } from "../../components/Header";
import { LicensePlateInput } from "../../components/LicensePlate";
import { Loading } from "../../components/Loading";
import { LocationInfo } from "../../components/LocationInfo";
import { TextAreaInput } from "../../components/TextAreaInput";
import { Container, Content, Message } from "./styles";

export function Departure() {
  const [description, setDescription] = useState("");
  const [licensePlate, setLicensePlate] = useState("");
  const [isLoadingLocation, setIsLoadingLocation] = useState(true);
  const [currentAddress, setCurrentAddress] = useState<string | null>(null);

  const descriptionRef = useRef<TextInput>(null);
  const licensePlateRef = useRef<TextInput>(null);

  const [locationForegroundPermission, requestLocationForegroundPermission] =
    useForegroundPermissions();


export async function getAddressLocation({
  latitude,
  longitude,
}: LocationObjectCoords) {
  try {
    const addressResponse = await reverseGeocodeAsync({ latitude, longitude });
    return addressResponse[0].street;
  } catch (error) {
    console.log(error);
  }
}


  useEffect(() => {
    requestLocationForegroundPermission();
  }, []);

  useEffect(() => {
    if (!locationForegroundPermission?.granted) {
      return;
    }
    let subscription: LocationSubscription;
    watchPositionAsync(
      {
        accuracy: LocationAccuracy.High,
        timeInterval: 1000,
      },
      (location) => {
        getAddressLocation(location.coords).then((address) => {
          if (address) {
            setCurrentAddress(address);
          }
        });
      }
    )
      .then((response) => (subscription = response))
      .finally(() => setIsLoadingLocation(false));
    return () => {
      if (subscription) {
        subscription.remove();
      }
    };
  }, [locationForegroundPermission?.granted]);

  if (!locationForegroundPermission?.granted) {
    return (
      <Container>
        <Header title="Saída" />
        <Message>
          Você precisa permitir que o aplicativo tenha acesso a localização para
          acessar essa funcionalidade. Por favor, acesse as configurações do seu
          dispositivo para conceder a permissão ao aplicativo.
        </Message>
      </Container>
    );
  }


  if (isLoadingLocation) {
    return <Loading />;
  }

  return (
    <Container>
      <Header title="Saída" />
      <KeyboardAwareScrollView extraHeight={300}>
        <ScrollView>
          <Content>
            {currentAddress && (
              <LocationInfo
                icon={CarSimple}
                label="Localização atual"
                description={currentAddress}
              />
            )}
            <LicensePlateInput
              label="Placa do veículo"
              placeholder="BRA1234"
              onSubmitEditing={() => descriptionRef.current?.focus()}
              returnKeyType="next"
              onChangeText={setLicensePlate}
            />
            <TextAreaInput
              ref={descriptionRef}
              label="Finalizade"
              placeholder="Vou utilizar o veículo para..."
              onSubmitEditing={handleDepartureRegister}
              returnKeyType="send"
              blurOnSubmit
              onChangeText={setDescription}
            />
            <Button title="Registar Saída" onPress={handleDepartureRegister} />
          </Content>
        </ScrollView>
      </KeyboardAwareScrollView>
    </Container>
  );
}
```

## Implementing maps
1. Install the expo-maps library running `npx expo install react-native-maps`.
2. Log into Google Cloud Platform console, select your project, click on "APIs & Services", select "Maps SDK for Android" and "Maps SDK for iOS", generate/get a same key for both services and store it as environment variables.
3. On your app.json, rename it for app.config.js and tell the Google API keys for each platform (same for both), example:
```javascript
  import * as dotenv from 'dotenv'

dotenv.config()

module.exports = {
  "expo": {
    "name": "iginte-fleet",
    "slug": "iginte-fleet",
    "version": "1.0.0",
    "orientation": "portrait",
    "icon": "./assets/icon.png",
    "userInterfaceStyle": "dark",
    "splash": {
      "image": "./assets/splash.png",
      "resizeMode": "contain",
      "backgroundColor": "#202024"
    },
    "assetBundlePatterns": [
      "**/*"
    ],
    "ios": {
      "supportsTablet": true,
      "bundleIdentifier": "com.pablosilva.ignitefleet",
      "config" : {
        "googleMapsApiKey": process.env.GOOGLE_MAPS_API_KEY
      }
    },
    "android": {
      "adaptiveIcon": {
        "foregroundImage": "./assets/adaptive-icon.png",
        "backgroundColor": "#202024"
      },
      "package": "com.pablosilva.ignitefleet",
      "config" : {
        "googleMapsApiKey": process.env.GOOGLE_MAPS_API_KEY
      }
    },
    "web": {
      "favicon": "./assets/favicon.png"
    },
    "plugins": [
      [
        "expo-location",
        {
          "locationAlwaysAndWhenInUsePermission": "Allow $(PRODUCT_NAME) to use your location."
        }
      ]
    ]
  }
}

  ```
  4. Create a component to render the map , map marker and the polyline for user track path. The provider must be `DEFAULT_PROVIDER` for iOS and `GOOGLE_PROVIDER` for Android.
  ```typescript
import { Car, FlagCheckered } from "phosphor-react-native";
import { useRef } from "react";
import { Platform } from "react-native";
import MapView, {
  LatLng,
  MapViewProps,
  Marker,
  PROVIDER_DEFAULT,
  PROVIDER_GOOGLE,
  Polyline,
} from "react-native-maps";
import { useTheme } from "styled-components/native";
import { IconBox } from "../IconBox";

type Props = MapViewProps & {
  coordinates: LatLng[];
};

export function Map({ coordinates, ...rest }: Props) {
  const lastCoordinate = coordinates[coordinates.length - 1];

  const mapRef = useRef<MapView>(null);
  const { COLORS } = useTheme();

  const EDGE_PADDING_VALUE = 50;

  async function autoCentralizeMap() {
    if (coordinates.length > 1) {
      mapRef.current?.fitToSuppliedMarkers(["departure", "arrival"], {
        edgePadding: {
          top: EDGE_PADDING_VALUE,
          bottom: EDGE_PADDING_VALUE,
          left: EDGE_PADDING_VALUE,
          right: EDGE_PADDING_VALUE,
        },
      });
    }
  }

  return (
    <MapView
      ref={mapRef}
      provider={Platform.OS === "android" ? PROVIDER_GOOGLE : PROVIDER_DEFAULT}
      style={{ width: "100%", height: 200 }}
      region={{
        latitude: lastCoordinate.latitude,
        longitude: lastCoordinate.longitude,
        latitudeDelta: 0.005,
        longitudeDelta: 0.005,
      }}
      onMapLoaded={autoCentralizeMap}
      {...rest}
    >
      <Marker identifier="departure" coordinate={coordinates[0]}>
        <IconBox icon={Car} size="SMALL" />
      </Marker>
      {coordinates.length > 1 && (
        <>
          <Marker identifier="arrival" coordinate={lastCoordinate}>
            <IconBox size="SMALL" icon={FlagCheckered} />
          </Marker>
          <Polyline
            coordinates={[...coordinates]}
            strokeColor={COLORS.BRAND_LIGHT}
            strokeWidth={4}
          />
        </>
      )}
    </MapView>
  );
}

  ```