package com.example.rahul.myapplication;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;

public class MainActivity extends AppCompatActivity {

    EditText editTextEmail, editTextPassword;
    Button buttonLogin;
    TextView textViewSignUp;
    ProgressDialog progressDialog;
    FirebaseAuth firebaseAuth;
    CheckBox patientCheckBox, doctorCheckBox;
    String type;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editTextEmail = findViewById(R.id.editTextEmail);
        editTextPassword = findViewById(R.id.editTextPassword);
        buttonLogin = findViewById(R.id.buttonLogin);
        textViewSignUp = findViewById(R.id.textViewSignUp);
        progressDialog = new ProgressDialog(this);
        firebaseAuth = FirebaseAuth.getInstance();
        patientCheckBox = findViewById(R.id.patientCheckBox);
        doctorCheckBox = findViewById(R.id.doctorCheckBox);

        patientCheckBox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked) {
                    type = "patient";
                }else type = "";
            }
        });

        doctorCheckBox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked) {
                    type = "doctor";
                }else type = "";
            }
        });

        textViewSignUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(MainActivity.this, RegisterActivity.class));
            }
        });

        buttonLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String email = editTextEmail .getText().toString().trim();

                final String password = editTextPassword.getText().toString().trim();

                String ready= "true";
                if (TextUtils.isEmpty(email)){

                    //email is empty
                    editTextEmail.setError(getString(R.string.error_field_required));
                    ready = "false";

                }

                if (TextUtils.isEmpty(password)){
                    //password is empty
                    editTextPassword.setError(getString(R.string.error_field_required));
                    ready = "false";
                }

                if (TextUtils.isEmpty(type)) {
                    Toast.makeText(MainActivity.this, "Selct either patient or doctor", Toast.LENGTH_SHORT).show();
                    ready = "false";
                }
                //if validations are ok
                if(ready.equals("true")) {
                    progressDialog.setMessage("Logging in...");
                    progressDialog.show();

                    firebaseAuth.signInWithEmailAndPassword(email, password)
                            .addOnCompleteListener(new OnCompleteListener<AuthResult>() {
                                @Override
                                public void onComplete(@NonNull Task<AuthResult> task) {

                                    if (type.equals("doctor")){
                                        startActivity(new Intent(getApplicationContext(),DoctorActivity.class));
                                    }else {
                                        startActivity(new Intent(getApplicationContext(),PatientActivity.class));
                                    }
                                }
                            });
                }
            }
        });

    }
}