# Understanding GO programs

Go is a compiled language for back-end.

## Configuring VS Code to work with GO

1. Download and install GO for your SO on the [official GO website](https://go.dev/doc/install).
2. On VS Code, search for `GO` extension and install/enable it.
3. Search for `go:install/update tools`, select and install all updates.

## Starting new projects with GO:

1. Run the command `go mod init github.com/your_user/your_repository`. A go.mod containing your project module name and GO version file will be created.
2. Create a folder named `cmd` and a file named `main.go` inside it.
3. Create a folder named `internal` to store files that will be used only by your program.
4. Write your program.
5. Use the command `go mod tidy` to install all dependencies required on your program.
6. Use the command `go run your_folder/main.go` to execute your Go program. Example: `go run cmd/simulator/main.go`


### Example of a file written using GO:

```go

// - The internal package suggests that the code within is meant to be shared only within other packages of the same application, not exposed to external packages.
package internal

//- This section imports the necessary libraries:
// fmt: Standard library for formatted I/O operations.
// math: Provides basic constants and mathematical functions.
// mongo, bson, options: Parts of the MongoDB Go driver used for database operations.
import (
	"fmt"
	"math"

	"go.mongodb.org/mongo-driver/bson"
	"go.mongodb.org/mongo-driver/mongo"
	"go.mongodb.org/mongo-driver/mongo/options"
)

// Directions structØ: Represents geographical coordinates with latitude and longitude.

type Directions struct {
	Lat float64 bson:"lat" json:"lat"
	Lng float64 bson:"lng" json:"lng"
}

// Route struct: Represents a delivery or travel route, with an ID, distance, series of directions, and a freight price. Tags like bson and json denote how these fields are encoded/decoded when working with MongoDB and JSON, respectively.
type Route struct {
	ID           string       bson:"_id" json:"id"
	Distance     int          bson:"distance" json:"distance"
	Directions   []Directions bson:"directions" json:"directions"
	FreightPrice float64      bson:"freight_price" json:"freight_price"
}

//Creates and returns a new Route instance
func NewRoute(id string, distance int, directions []Directions) Route {
	return Route{
		ID:         id,
		Distance:   distance,
		Directions: directions,
	}
}

type RouteService struct {
	mongo          *mongo.Client
	FreightService *FreightService
}

func NewRouteService(mongo *mongo.Client, freightService *FreightService) *RouteService {
	return &RouteService{
		mongo:          mongo,
		FreightService: freightService,
	}
}

type FreightService struct{}

func NewFreightService() *FreightService {
	return &FreightService{}
}

func (fs *FreightService) Calculate(distance int) float64 {
	return math.Floor((float64(distance)*0.15+0.3)*100) / 100
}

// Adds or updates a route in the MongoDB database, including freight cost calculation
func (rs *RouteService) CreateRoute(route Route) (Route, error) {
	// Use FreightService to perform necessary calculations
	freightCost := rs.FreightService.Calculate(route.Distance)
	route.FreightPrice = freightCost
	fmt.Printf("Calculated freight cost: %.2f\n", freightCost)

	// Add freight cost to the route as needed (assume you want to store it)
	update := bson.M{
		"$set": bson.M{
			"distance":      route.Distance,
			"directions":    route.Directions,
			"freight_price": freightCost, // Store the calculated freight cost
		},
	}

	// Filter to find document by ID
	filter := bson.M{"_id": route.ID}

	// Upsert option to insert if not exists
	opts := options.Update().SetUpsert(true)

	// Perform the update or insert operation
	_, err := rs.mongo.Database("routes").Collection("routes").UpdateOne(nil, filter, update, opts)

	return route, err
}

//  Retrieves a route by its ID from MongoDB, printing it out.
func (rs *RouteService) GetRoute(id string) (Route, error) {
	var route Route
	filter := bson.M{"_id": id}
	err := rs.mongo.Database("routes").Collection("routes").FindOne(nil, filter).Decode(&route)
	fmt.Printf("Found route: %+v\n", route)
	return route, err
}
```
