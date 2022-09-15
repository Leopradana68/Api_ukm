<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use http\Env\Response;

class AuthController extends Controller
{

    public function login(Request $request){

        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'max:100', 'min:6'],
            'password' => ['required', 'string', 'max:255', 'min:6'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Tidak berhasil login, data yang diberikan tidak valid',
                '__func' => 'AUTH Login',
            ], 422);
        }

        // Cek jika email user tersedia di tabel
        if (User::where('email', $request->email)->exists()) {

            // Eksekusi query mengambil data user
            $data = User::where('email', $request->email)->first();

            // Cek password yang dikirim apakah sesuai dengan yang ada di tabel
            if (!Hash::check($request->password, $data->password)) {

                return response()->json([
                    'data' => 'Password: ' . $data->password,
                    '__message' => 'Tidak berhasil login, password tidak cocok',
                    '__func' => 'AUTH Login',
                ], 422);

            }

            if ($data) {
                // Membuat bearer token sanctum untuk authentikasi
                $tokenResult = $data->createToken('authToken')->plainTextToken;

                // Jika berhasil maka kembalikan response error
                return response()->json([
                    'token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'data' => $data,
                    '__message' => 'Berhasil login',
                    '__func' => 'AUTH Login',
                ], 200);
            }

            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $data,
                '__message' => 'Terdapat kesalahan saat login, coba kembali beberapa saat',
                '__func' => 'AUTH login',
            ], 500);

        } else {

            // Jika user tidak ditemukan maka kembalikan response error
            return response()->json([
                'data' => 'Email: ' . $request->email,
                '__message' => 'Tidak berhasil login, pengguna tidak ditemukan',
                '__func' => 'AUTH Login',
            ], 500);
        }
    }

    
    public function register(Request $request) {
        
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:200', 'min:3'],
            'email' => ['required', 'email', 'max:100', 'min:6'],
            'password' => ['required', 'string', 'max:255', 'min:6'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Tidak berhasil mendaftar, data yang diberikan tidak valid',
                '__func' => 'AUTH register',
            ], 422);
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'data' => 'Email: ' . $request->email,
                '__message' => 'Tidak berhasil mendaftar, user dengan email yang diberikan sudah terdaftar',
                '__func' => 'AUTH register',
            ], 422);
        }

        // Eksekusi pembuatan data user baru
        $query = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'User berhasil dibuat',
                '__func' => 'AUTH register',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'User tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'AUTH register',
        ], 500);
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile() {
        return response()->json(auth()->user());
    }

    // protected function createNewToken($token){
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60,
    //         'user' => auth()->user()
    //     ]);
    // }
}