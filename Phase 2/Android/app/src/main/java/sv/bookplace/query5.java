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
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.Spinner;

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
import java.util.HashMap;

public class query5 extends Fragment {

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.query5, container, false);
    }


    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        getActivity().setTitle("Query 5");

        final ListView lstView = (ListView) getView().findViewById(R.id.listviewYears);
        final Spinner yearChoice = (Spinner) getView().findViewById(R.id.yearChoice);
        final ArrayList<String> lst = new ArrayList<>();

        StringRequest stringRequest = new StringRequest(Request.Method.GET, MainActivity.serverURL_years,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("!!!", response);
                        try {
                            JSONArray jarray = new JSONArray(response);
                            ArrayList<String> titleList = new ArrayList<>();

                            for (int i = 0; i < jarray.length(); i++)
                            {
                                titleList.add((new JSONObject(jarray.get(i).toString())).getString("year").toString());
                            }

                            ArrayAdapter<String> dataAdapter = new ArrayAdapter<>(getContext(),
                                    android.R.layout.simple_spinner_item, titleList);
                            dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            yearChoice.setAdapter(dataAdapter);
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

        yearChoice.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                String item = parent.getItemAtPosition(position).toString();
                StringRequest stringRequest = new StringRequest(Request.Method.GET, MainActivity.serverURL_query5 + "?year=" + item,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                try {
                                    JSONArray jarray = new JSONArray(response);
                                    ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>
                                            (getActivity().getApplicationContext(), android.R.layout.simple_list_item_1, lst);

                                    ArrayList<HashMap<String, String>> titleLst = new ArrayList<>();

                                    for (int i = 0; i < jarray.length(); i++) {
                                        HashMap<String, String> hm = new HashMap<>();
                                        hm.put("title", (new JSONObject(jarray.get(i).toString())).getString("title"));
                                        hm.put("price", (new JSONObject(jarray.get(i).toString())).getString("price"));
                                        hm.put("isbn", (new JSONObject(jarray.get(i).toString())).getString("ISBN13"));
                                        hm.put("num", (new JSONObject(jarray.get(i).toString())).getString("purchases"));
                                        titleLst.add(hm);
                                    }

                                    String[] from = {"title", "num" };
                                    int[] to = {R.id.title, R.id.subitem};

                                    SimpleAdapter simpleAdapter = new SimpleAdapter(getActivity().getApplicationContext(), titleLst, R.layout.row, from, to);
                                    lstView.setAdapter(simpleAdapter);
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

            public void onNothingSelected(AdapterView<?> parent) {}
        });
    }
}
