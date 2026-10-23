'use strict';

const form = document.querySelector('#cep-form');
const input = document.querySelector('#cep');
const submit = document.querySelector('#submit');
const feedback = document.querySelector('#feedback');
const empty = document.querySelector('#empty-state');
const result = document.querySelector('#result');

input.addEventListener('input', () => {
  const digits = input.value.replace(/\D/g, '').slice(0, 8);
  input.value = digits.length > 5 ? `${digits.slice(0, 5)}-${digits.slice(5)}` : digits;
  input.setCustomValidity('');
});

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  if (submit.disabled) return;
  const cep = input.value.replace('-', '');
  if (!/^\d{8}$/.test(cep)) {
    input.setCustomValidity('Informe os 8 números do CEP.');
    input.reportValidity();
    return;
  }
  submit.disabled = true;
  submit.textContent = 'Consultando…';
  form.setAttribute('aria-busy', 'true');
  result.hidden = true;
  empty.hidden = true;
  feedback.className = 'loading';
  feedback.textContent = 'Buscando seu endereço…';
  const controller = new AbortController();
  const timeout = setTimeout(() => controller.abort(), 18000);
  try {
    const response = await fetch(`api/cep.php?cep=${encodeURIComponent(cep)}`, { signal: controller.signal, headers: { Accept: 'application/json' } });
    const body = await response.json();
    if (!response.ok) throw new Error(body.error || 'Não foi possível realizar a consulta.');
    const address = body.data;
    result.querySelectorAll('[data-field]').forEach((element) => {
      element.textContent = address[element.dataset.field] || 'Não informado';
    });
    document.querySelector('#result-title').textContent = address.logradouro || 'Endereço encontrado';
    document.querySelector('#result-location').textContent = `${address.localidade} · ${address.uf}`;
    feedback.textContent = '';
    result.hidden = false;
  } catch (error) {
    feedback.className = 'error';
    feedback.textContent = error.name === 'AbortError'
      ? 'A consulta demorou mais que o esperado. Tente novamente.'
      : error instanceof SyntaxError || error instanceof TypeError
        ? 'Não foi possível conectar ao servidor. Confira se o site está sendo executado com PHP.'
        : error.message;
  } finally {
    clearTimeout(timeout);
    submit.disabled = false;
    submit.innerHTML = 'Consultar <span aria-hidden="true">↗</span>';
    form.removeAttribute('aria-busy');
  }
});

document.querySelectorAll('[data-cep]').forEach((button) => {
  button.addEventListener('click', () => {
    if (submit.disabled) return;
    const cep = button.dataset.cep;
    input.value = `${cep.slice(0, 5)}-${cep.slice(5)}`;
    input.setCustomValidity('');
    form.requestSubmit();
  });
});
