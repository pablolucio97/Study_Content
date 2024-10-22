# Doing Uploads with Multer

1. Install multer and its types:
`npm i multer`, `npm i @types/multer`

---

2. Inside the `src` folder, create a new folder named `config` and inside it, create a new file named `multer.ts`. Also, create a folder named `uploads` inside `src` to store your uploaded files.

---

3. Configure your `multer` file. Example:

`import multer from 'multer' import path from 'path' import crypto from 'crypto' export default{ storage: multer.diskStorage({ destination: path.resolve(__dirname, '..', 'uploads'), filename(request, file, callback){ const hash = crypto.randomBytes(6).toString('hex') const fileName = `${hash}-${file.originalname}` callback(null, fileName) } }) }`

---

4. Import `multer` as `multerConfig` in your routes file, instantiate it, and use it in the POST route. Example:

`import multer from 'multer' import multerConfig from './src/config/multer' const upload = multer(multerConfig) routes.post('/create-object', upload.single('img'), usingObjectController.create)`

---

5. Adjust your POST route in your controller. Example:

`async create (req: Request, res: Response){ try{ const {name} = req.body const avatar= req.file.filename const result = await db('users').insert({name, avatar}) const userId = result[0] return res.status(200).json({ name, avatar, userId }) }catch(error){ console.log(error) } }`
