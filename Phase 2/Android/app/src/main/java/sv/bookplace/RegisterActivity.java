package sv.bookplace;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.EditText;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class RegisterActivity extends AppCompatActivity {

    private EditText emailText, passwordText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        emailText = (EditText) findViewById(R.id.email);
        passwordText = (EditText) findViewById(R.id.password);

    }

    public void runSignUp(View view) throws JSONException {
        final String email = emailText.getText().toString().trim();
        final String pw = passwordText.getText().toString().trim();

        StringRequest stringRequest = new StringRequest(Request.Method.POST, MainActivity.serverURL_register,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("POS", response);
                        try {
                            JSONObject obj = new JSONObject(response);
                            if (obj.getString("auth").equals("true"))
                            {
                                SharedPreferences.Editor pref = PreferenceManager.getDefaultSharedPreferences(RegisterActivity.this).edit();
                                pref.putString("auth", obj.getString("auth"));
                                pref.putString("token", obj.getString("token"));
                                pref.apply();

                                Intent intent = new Intent(RegisterActivity.this, HomeActivity.class);
                                startActivity(intent);
                            }
                            else if (obj.getString("auth").equals("false"))
                            {
                                if (obj.getString("error").equals("register_user_exists"))
                                {
                                    AlertDialog.Builder alert = new AlertDialog.Builder(RegisterActivity.this);
                                    alert.setCancelable(false);
                                    alert.setTitle("User exists");
                                    alert.setMessage("This email already exists. Please choose another email.");
                                    alert.setPositiveButton("Ok", null);
                                    alert.create().show();
                                }
                            }
                            else
                            {
                                // Login failed
                                Log.d("logF", "fail");
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.d("logE", error.getMessage());
                    }
                }){

            @Override
            protected Map<String,String> getParams(){
                Map<String, String> parameters = new HashMap<>();
                parameters.put("email", email.trim());
                parameters.put("password", Base64.encodeToString(pw.trim().getBytes(), Base64.DEFAULT));
                return parameters;
            }
        };

        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
}
