package sv.bookplace;

import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class query3 extends Fragment {

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.query3, container, false);
    }


    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        getActivity().setTitle("Query 3");

        final EditText authorName = (EditText) getView().findViewById(R.id.authorName);
        final ListView lstView = (ListView) getView().findViewById(R.id.listview);

        authorName.addTextChangedListener(new TextWatcher() {
            public void afterTextChanged(Editable s) {
                final String text = s.toString();
                StringRequest stringRequest = new StringRequest(Request.Method.GET, MainActivity.serverURL_query3 + "?auth_name=" + text.trim(),
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                try {
                                    JSONArray jarray = new JSONArray(response);
                                    ArrayList<String> lst = new ArrayList<String>();
                                    ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>
                                            (getActivity().getApplicationContext(), android.R.layout.simple_list_item_1, lst);
                                    lstView.setAdapter(arrayAdapter);
                                    for (int i = 0; i < jarray.length(); i++)
                                    {
                                        lst.add((new JSONObject(jarray.get(i).toString())).getString("title").toString());
                                    }
                                    arrayAdapter.notifyDataSetChanged();
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
                        });

                RequestQueue requestQueue = Volley.newRequestQueue(getActivity().getApplicationContext());
                requestQueue.add(stringRequest);
            }

            public void beforeTextChanged(CharSequence s, int start, int count, int after) {}
            public void onTextChanged(CharSequence s, int start, int before, int count) {}
        });
    }
}
