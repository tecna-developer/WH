function setMessage(form, text, isError) {
  const existing = form.querySelector(".form__message");
  if (existing) existing.remove();

  const message = document.createElement("p");
  message.className = isError
    ? "form__message form__message--error"
    : "form__message";
  message.textContent = text;
  form.appendChild(message);
}

export function initSubscription() {
  const form = document.querySelector(".subscription .form");
  if (!form || typeof whSubscription === "undefined") return;

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const emailInput = form.querySelector("#email");
    const button = form.querySelector(".form__btn");
    button.disabled = true;

    try {
      const response = await fetch(whSubscription.ajaxUrl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
          action: "wh_subscribe",
          nonce: whSubscription.nonce,
          email: emailInput.value.trim(),
        }),
      });
      const data = await response.json();

      setMessage(form, data.data?.message ?? "", !data.success);
      if (data.success) form.reset();
    } catch {
      setMessage(form, "Something went wrong, please try again.", true);
    } finally {
      button.disabled = false;
    }
  });
}
